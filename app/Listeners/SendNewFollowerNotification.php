<?php

namespace App\Listeners;

use App\Events\FollowCreated;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendNewFollowerNotification
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
     * @param  FollowCreated  $event
     * @return void
     */
    public function handle(FollowCreated $event)
    {
        $follower = $event->follower;
        $followed = $event->followed;

        if (!$followed->meta['notifications']['new_follower']['email']) {
            return;
        }

        if ($followed->following()->where(['followed_id' => $follower->id])->count()) {
            $followed->notify(new \App\Notifications\FollowedBack($follower));
        } else {
            $followed->notify(new \App\Notifications\NewFollower($follower));
        }
    }
}
