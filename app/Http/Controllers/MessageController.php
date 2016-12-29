<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Message;

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

    /**
     * Show the answer form.
     *
     * @return \Illuminate\Http\Response
     */
    public function answerForm(int $message_id)
    {
        $message = \App\Message::find($message_id);

        return view('message.answer_form', ['message' => $message]);
    }

    /**
     * Answer the message
     *
     * @return \Illuminate\Http\Response
     */
    public function answer(int $message_id, Request $request)
    {
        $answer = $request->input('answer');

        $message = Message::find($message_id);
        $message->answer = $answer;
        $message->status_id = Message::STATUS_ANSWERED_PUBLICLY;
        $message->save();

        return redirect($message->recipient->username)->with('success', 'Answer published! 😃');
    }
}
