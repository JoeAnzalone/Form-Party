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
        //
    }
}
