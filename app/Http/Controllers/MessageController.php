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
        $message_body = $request->input('message');
        $recipient_id = $request->input('recipient_id');

        $message = new \App\Message();
        $message->body = $message_body;
        $message->user_id = $recipient_id;
        $message->from_ip = $request->ip();

        $message->save();
        $recipient = \App\User::findOrFail($recipient_id);
        return redirect($recipient->username)->with('success', sprintf('Message sent to %s! 😃', $recipient->username));
    }
}
