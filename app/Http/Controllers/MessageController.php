<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Message;

class MessageController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'store']);
    }

    /**
     * Show the user's unanswered messages
     *
     * @return \Illuminate\Http\Response
     */
    public function inbox()
    {
        $user = Auth::user();
        $messages = $user->messages()->where('status_id', Message::STATUS_UNANSWERED)->orderBy('created_at', 'desc')->paginate(10);

        return view('message.inbox', ['title' =>  'Inbox', 'messages' => $messages]);
    }

    /**
     * Store the message
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
    public function answerForm(Message $message)
    {
        $this->authorize('answer', $message);

        return view('message.answer_form', ['message' => $message]);
    }

    /**
     * Answer the message
     *
     * @return \Illuminate\Http\Response
     */
    public function answer(Message $message, Request $request)
    {
        $this->authorize('answer', $message);

        $answer = $request->input('answer');
        $message->answer = $answer;
        $message->status_id = Message::STATUS_ANSWERED_PUBLICLY;
        $message->save();

        return redirect($message->recipient->username)->with('success', 'Answer published! 😃');
    }
}
