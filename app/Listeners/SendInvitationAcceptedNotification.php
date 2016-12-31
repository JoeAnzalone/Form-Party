<?php

namespace App\Listeners;

use App\Events\InvitationAccepted;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

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
     * @param  InvitationAccepted  $event
     * @return void
     */
    public function handle(InvitationAccepted $event)
    {
        //
    }
}
