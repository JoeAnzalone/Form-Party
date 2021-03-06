<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        $no_admin_overrides = ['follow', 'unfollow'];

        if ($user->is_admin && !in_array($ability, $no_admin_overrides)) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the list of all users.
     *
     * @param  \App\User  $authedUser
     * @return mixed
     */
    public function index(User $authedUser)
    {
        return false;
    }

    /**
     * Determine whether the user can view the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function view(User $authedUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can create users.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $authedUser)
    {
        //
    }

    /**
     * Determine whether the user can update the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function update(User $authedUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can delete the user.
     *
     * @param  \App\User  $user
     * @param  \App\User  $user
     * @return mixed
     */
    public function delete(User $authedUser, User $user)
    {
        //
    }

    /**
     * Determine whether the user can follow the user.
     *
     * @param  \App\User  $authedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function follow(User $authedUser, User $user)
    {
        return (
            !$authedUser->is($user) &&
            !$authedUser->following()->where(['followed_id' => $user->id])->count()
        );
    }

    /**
     * Determine whether the user can unfollow the user.
     *
     * @param  \App\User  $authedUser
     * @param  \App\User  $user
     * @return mixed
     */
    public function unfollow(User $authedUser, User $user)
    {
        return (
            !$authedUser->is($user) &&
            $authedUser->following()->where(['followed_id' => $user->id])->count()
        );
    }

    /**
     * Determine whether the user can sidestep the minimum username length
     *
     * @param  \App\User  $authedUser
     * @return mixed
     */
    public function shortUsername(User $authedUser)
    {
        return $authedUser->meta['permissions']['short_username'];
    }
}
