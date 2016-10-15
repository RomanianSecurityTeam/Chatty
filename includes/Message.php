<?php

namespace Chatty;

use Chatty\Traits\Auth;
use Chatty\Traits\Responses;
use Chatty\Traits\Scanner;

class Message
{
    const CHAT_API_POST_URL = 'https://server10.ips-chat-service.com/post.php';

    use Auth, Scanner, Responses;

    public $message;

    public $timestamp;
    public $type;
    public $author;
    public $text;
    public $code;
    public $id;

    private $worker;

    public function __construct($message, $worker)
    {
        $this->message = (object) array_combine(['timestamp', 'type', 'author', 'text', 'code', 'id'], $message);
        $this->worker = $worker;

        foreach ($this->message as $key => $value) {
            $this->$key = $value;
        }
    }

    public function getCommand($prefix)
    {
        if (preg_match('#^' . $prefix . ' (.*)#i', $this->message->text, $command)) {
            return $command[1];
        }

        return false;
    }

    public function isPrefixed($prefix)
    {
        return preg_match('#^' . str_replace('#', '\#', $prefix) . '#i', $this->message->text);
    }

    public function respond($response, $prefix = true)
    {
        $prefix = $prefix ? "@$this->author: " : '';

        $this->postMessage("{$prefix}$response", function ($message, $response) {
            echo "$message->author ($message->text): $response <br />\n";
            ob_flush();
            flush();
        });
    }

    private function answerable()
    {
        return ! in_array($this->message->timestamp . $this->message->author, $this->worker->answeredMessages);
    }

    private function postMessage($response, \Closure $callback)
    {
        if ($_SESSION['dontRespond'] || ! $this->answerable()) {
            return;
        }

        $this->worker->lastSentMessageTimestamp = time();

        $replacerKeys = ["\n", ',', '=', '+', '&', '%'];
        $replacerValues = ['__N__', '__C__', '__E__', '__PS__', '__A__', '__P__'];

        $this->worker->loggedClient->post(
            static::CHAT_API_POST_URL . '?' . http_build_query($this->worker->chatApiGetData),
            ['form_params' => ['message' => str_replace($replacerKeys, $replacerValues, $response)]]
        );

        $this->worker->answeredMessages[] = $this->message->timestamp . $this->message->author;

        $callback($this, $response);
    }

    public function kick($user)
    {
        $users = $this->getUserList(true);
        if (! isset($users[$user])) {
            return;
        }

        $this->worker->loggedClient->post(
            'https://server10.ips-chat-service.com/moderate.php?' . http_build_query($this->chatApiGetData),
            ['form_params' => ['against' => $users[$user]]]
        );

        $this->worker->answeredMessages[] = $this->message->timestamp . $this->message->author;
    }

    public function parse()
    {
        if ($_SESSION['dontRespond']) {
            return;
        }

        $this->scanRandom();
        $this->scanAI();
        $this->scanCommands();

        if ($this->worker->lastSentMessageTimestamp + 60 < time()) {
            $this->needsToRelogin = true;
        }
    }
}