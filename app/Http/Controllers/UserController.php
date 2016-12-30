<?php

namespace App\Http\Controllers;

use App\User;
use App\Message;

class UserController extends Controller
{
    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $messages = $user->messages->where('status_id', Message::STATUS_ANSWERED_PUBLICLY)->sortByDesc('updated_at');

        $title = sprintf(
            '%s%s Form Party',
            $user->username,
            ends_with($user->username, 's') ? "'" : "'s"
        );

        return view('user.profile', ['title' =>  $title, 'user' => $user, 'messages' => $messages]);
    }

    /**
     * Show the user's list of invite codes.
     *
     * @return \Illuminate\Http\Response
     */
    public function listInvites()
    {
        $user = \Auth::user();
        if (!$user->has_invites) {
            abort(404);
        }

        $invites = $user->invites;
        return view('user.invites', ['title' =>  'Invite', 'invites' => $invites]);
    }
}
