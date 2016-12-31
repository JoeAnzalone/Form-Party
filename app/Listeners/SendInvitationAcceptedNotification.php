<?php

namespace App\Listeners;

use App\Events\InvitationAccepted as InviteAcceptedEvent;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use App\Notifications\InvitationAccepted as InviteAcceptedNotification;

class SendInvitationAcceptedNotification
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
     * @param  InviteAcceptedEvent  $event
     * @return void
     */
    public function handle(InviteAcceptedEvent $event)
    {
        $invite = $event->invite;
        $invite->user->notify(new InviteAcceptedNotification($invite));
    }
}
