<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\UserCreated' => ['App\Listeners\SendWelcomeMessage', 'App\Listeners\GiveInvites'],
        'App\Events\InvitationAccepted' => ['App\Listeners\SendInvitationAcceptedNotification'],
        'App\Events\MessageSent' => ['App\Listeners\SendMessageNotification',],
        'App\Events\FollowCreated' => ['App\Listeners\SendNewFollowerNotification',],
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

         \App\User::created(function($user) {
            event(new \App\Events\UserCreated($user));
        });

         \App\Message::created(function($message) {
            event(new \App\Events\MessageSent($message));
        });

         \App\Invite::updated(function($invite) {
            $original = $invite->getOriginal();

            if (is_null($original['claimed_by_id']) && !empty($invite->claimed_by_id)) {
                event(new \App\Events\InvitationAccepted($invite));
            }
        });
    }
}
