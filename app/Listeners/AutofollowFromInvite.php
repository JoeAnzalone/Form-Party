<?php

namespace App\Listeners;

use App\Events\InvitationAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class AutofollowFromInvite
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
     * @param  InvitationAccepted  $event
     * @return void
     */
    public function handle(InvitationAccepted $event)
    {
        $invite = $event->invite;

        $invite->user->follow($invite->claimed_by, false);
        $invite->claimed_by->follow($invite->user, false);
    }
}
