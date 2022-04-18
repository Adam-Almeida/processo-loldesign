<?php

namespace Source\Core;

use League\Plates\Engine;
use Source\Boot\Message;
use Source\Models\Auth;

abstract class Controller
{
    /** @var Engine */
    protected $view;

    /** @var Message */
    protected $message;

    public function __construct()
    {
        $this->view = new Engine(__DIR__ . "/../../theme/", "php");
        $this->message = new Message();

        if (!Auth::user()) {
            redirect("/login");
        }
    }
    /**
     * @param string $message
     * @param string $title
     * @param string $type
     */
    protected function message(string $message, string $title, string $type)
    {
        $this->message->renderMessage($message, $title, $type)->flash();
    }

}