<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendWelcomeMessage
{
    const WELCOME_MESSAGES = [
        "You're on Form Party! Yay! \o/\r\n\r\n-mgmt",
        "Welcome to the Form Party!\r\n\r\n-mgmt",
        "hey there! ;)\r\n\r\n-mgmt",
        "This is your first \"anonymous\" message!\r\n\r\n-mgmt",
        "Have you ever received an anonymous message before? Now you have!\r\n\r\n-mgmt",
    ];

    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  UserCreated  $event
     * @return void
     */
    public function handle(UserCreated $event)
    {
        $message = new \App\Message();
        $message->body = self::WELCOME_MESSAGES[array_rand(self::WELCOME_MESSAGES)];
        $message->from_ip = 0;

        $event->user->messages()->save($message);
    }
}
