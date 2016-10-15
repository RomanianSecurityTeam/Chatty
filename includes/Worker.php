<?php

namespace Chatty;

use Chatty\Traits\Auth;

require_once 'config.php';

class Worker
{
    use Auth;

    const CHAT_URL = 'https://rstforums.com/forum/chat/';
    const CHAT_API_GET_URL = 'https://server10.ips-chat-service.com/get.php';

    public $currentChatMessages;
    public $currentLastMessage = 0;
    public $answeredMessages = [];
    public $needsToRelogin = false;
    public $lastSentMessageTimestamp;

    public function __construct()
    {
        $this->lastSentMessageTimestamp = time();
        $this->init();
    }

    public function init()
    {
        $_SESSION['votekicks'] = [];
        $this->login();
        $this->startCheckingMessages();
    }

    public function startCheckingMessages()
    {
        $_SESSION['dontRespond'] = true;
        $this->getChatContents();
        $this->parseMessages();
        $_SESSION['dontRespond'] = false;

        while (true) {
            $this->getChatContents();
            $this->parseMessages();

            sleep(1);

            if ($this->needsToRelogin) {
                $this->init();
                return;
            }
        }
    }

    private function getChatContents()
    {
        $response = $this->loggedClient->get(
            static::CHAT_API_GET_URL . '?' . http_build_query($this->chatApiGetData)
        )->getBody()->getContents();

        $parsedData = array_map(function ($item) {
            return explode(",", $item);
        }, explode("~~||~~", $response));

        $this->getLatestMessages(array_slice($parsedData, 1, -1));
    }

    public function getLatestMessages($latestOnlineMessages)
    {
        $replacerKeys = ['__N__', '__C__', '__E__', '__PS__', '__A__', '__P__'];
        $replacerValues = ["\n", ',', '=', '+', '&', '%'];
        $this->currentChatMessages = [];

        foreach ($latestOnlineMessages as $i => $message) {
            if ($message[0] > $this->currentLastMessage) {
                $message[3] = str_replace($replacerKeys, $replacerValues, $message[3]);
                $this->currentChatMessages[] = new Message($message, $this);
            }
        }

        if (isset($message)) {
            $this->currentLastMessage = $message[0];
        }
    }

    private function parseMessages()
    {
        foreach ($this->currentChatMessages as $message) {
            $message->parse();
        }
    }
}