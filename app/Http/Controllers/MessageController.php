<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MessageController extends Controller
{
    /**
     * Show the message form.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(string $username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();

        return view('form.show', ['user' => $user]);
    }

    /**
     * Show the form.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $message = $request->input('message');
        $recipient_username = $request->input('recipient_username');
        dump($recipient_username);
        dd($message);
    }
}
