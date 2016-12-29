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

        return view('user.profile', ['user' => $user, 'messages' => $messages]);
    }
}
