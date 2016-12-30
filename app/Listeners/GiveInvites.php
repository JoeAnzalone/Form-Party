<?php

namespace App\Listeners;

use App\Events\UserCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class GiveInvites
{
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
        $invite_count = config('app.new_user_invites');

        for ($i = 0; $i < $invite_count; $i++) {
            $invite = new \App\Invite();

            $event->user->invites()->save($invite);
        }
    }
}
