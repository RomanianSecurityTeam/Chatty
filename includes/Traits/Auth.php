<?php

namespace Chatty\Traits;

use GuzzleHttp\Client;

trait Auth
{
    private $authURL = 'https://rstforums.com/forum/login/';
    private $chatURL = 'https://rstforums.com/forum/chat/';
    private $userAgent = 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_11_4) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/52.0.2715.0 Safari/537.36';

    public $chatApiGetData;
    public $loggedClient;

    public function login()
    {
        $this->loggedClient = new Client(['cookies' => true]);
        $response = $this->loggedClient->get($this->authURL);
        $csrfKey = preg_get('#csrfKey: "([^"]+)"#', $response->getBody()->getContents());

        $this->loggedClient->post($this->authURL, [
            'form_params' => [
                'login__standard_submitted' => 1,
                'csrfKey'                   => $csrfKey,
                'auth'                      => env('USER'),
                'password'                  => env('PASS'),
                'remember_me'               => 0,
                'remember_me_checkbox'      => 1,
                'signin_anonymous'          => 0,
            ],
            'headers'     => [
                'Referer'    => $this->authURL,
                'User-Agent' => $this->userAgent,
            ],
        ]);

        $this->connectToChat();
    }

    private function connectToChat()
    {
        $chatHTML = $this->loggedClient->get($this->chatURL)->getBody()->getContents();
        $this->chatApiGetData = [
            'room'       => preg_get("#ips.setSetting\( 'roomID', (\d+) \);#", $chatHTML),
            'user'       => preg_get("#ips.setSetting\( 'userID', (\d+) \);#", $chatHTML),
            'access_key' => preg_get("#ips.setSetting\( 'accessKey', '([^']+)' \);#", $chatHTML),
            'msg'        => 0,
            'charset'    => 'utf-8',
        ];
    }

    public function getUserList($getIds = false)
    {
        if (! $this->loggedClient) {
            $this->login();
        }

        $users = [];
        $response = $this->loggedClient->get($this->chatURL)->getBody()->getContents();
        $ignoreUsers = ['Chatty'];

        if (preg_match_all('#elChatUserRow_(\d+).*?<div class=\'cChatUsername\'>.*?\t(.*?) <#s', $response, $results)) {
            if ($getIds) {
                foreach ($results[1] as $i => $id) {
                    $user = trim(strip_tags($results[2][$i]));
                    if (! in_array($user, $ignoreUsers)) {
                        $users[$user] = $id;
                    }
                }
            } else {
                $users = array_values(array_diff(array_map(function ($user) {
                    return trim(strip_tags($user));
                }, $results[2]), $ignoreUsers));
            }
        }

        return $users;
    }

    public function isAdmin()
    {
        return in_array($this->author, ['Gecko', 'aelius', 'tex']);
    }
}