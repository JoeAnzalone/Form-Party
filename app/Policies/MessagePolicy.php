<?php

namespace App\Policies;

use App\User;
use App\Message;
use Illuminate\Auth\Access\HandlesAuthorization;

class MessagePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function view(User $user, Message $message)
    {
        return $message->is_public || $user->is($message->recipient);
    }

    /**
     * Determine whether the user can create messages.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function update(User $user, Message $message)
    {
        //
    }

    /**
     * Determine whether the user can answer the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function answer(User $user, Message $message)
    {
        return (
            $user->is($message->recipient) &&
            !$message->trashed() &&
            in_array($message->status_id, [Message::STATUS_UNANSWERED, Message::STATUS_ANSWERED_PUBLICLY])
        );
    }

    /**
     * Determine whether the user can archive the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function archive(User $user, Message $message)
    {
        return (
            $user->is($message->recipient) &&
            !$message->trashed() &&
            $message->status_id === Message::STATUS_UNANSWERED
        );
    }

    /**
     * Determine whether the user can un-archive the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function unarchive(User $user, Message $message)
    {
        return (
            $user->is($message->recipient) &&
            !$message->trashed() &&
            $message->status_id === Message::STATUS_ARCHIVED
        );
    }

    /**
     * Determine whether the user can delete the message.
     *
     * @param  \App\User  $user
     * @param  \App\Message  $message
     * @return mixed
     */
    public function delete(User $user, Message $message)
    {
        return (
            $user->is($message->recipient) &&
            !$message->trashed() &&
            in_array($message->status_id, [Message::STATUS_ARCHIVED, Message::STATUS_ANSWERED_PUBLICLY])
        );
    }
}
