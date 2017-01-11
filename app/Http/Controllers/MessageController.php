<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use App\Message;
use App\User;

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
     * Show the user's dashboard
     *
     * @return \Illuminate\Http\Response
     */
    public function dashboard()
    {
        $user = Auth::user();

        $messages = Message::with('recipient')->where(function ($query) use ($user) {
            $query->whereIn('user_id', function($query) use ($user) {
                $query->select('followed_id')
                    ->from('user_follows')
                    ->where('follower_id', $user->id);
            })->orWhere('user_id', $user->id);
        })->where(function ($query) use ($user) {
            $query->where('status_id', Message::STATUS_ANSWERED_PUBLICLY);
        })->orderBy('answered_at', 'desc')->orderBy('updated_at', 'desc')->paginate(10);

        return view('message.dashboard', ['messages' => $messages, 'show_heading' => true]);
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

        $title = 'Inbox';
        $count = $user->unanswered_message_count;
        $count = number_format($count);
        $title = $count ? sprintf('(%s) %s', $count, $title) : $title;

        return view('message.inbox', ['title' =>  $title, 'messages' => $messages]);
    }

    /**
     * Show the user's archived messages
     *
     * @return \Illuminate\Http\Response
     */
    public function viewArchive()
    {
        $user = Auth::user();
        $messages = $user->messages()->where('status_id', Message::STATUS_ARCHIVED)->orderBy('created_at', 'desc')->paginate(10);

        return view('message.inbox', ['title' =>  'Message Archive', 'messages' => $messages]);
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
     * Show the message
     *
     * @return \Illuminate\Http\Response
     */
    public function permalink(string $username, Message $message)
    {
        $this->authorize('view', $message);

        $message_username = $message->recipient->username;

        if (strcasecmp($username, $message_username) !== 0) {
            // The username supplied in the URL doesn't match the recipient
            // We should trust the message ID, not the username
            // (Usernames can change after the permalink has been shared)

            // Redirect to the proper username
            return redirect()->route('message.permalink', [$message_username, $message]);
        }

        return view('message.permalink', ['message' => $message]);
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
        $message->answered_at = $message->answered_at ?: $message->freshTimestamp();
        $message->status_id = Message::STATUS_ANSWERED_PUBLICLY;
        $message->save();

        return redirect($message->recipient->username)->with('success', 'Answer published! 😃');
    }

    /**
     * Archive the message
     *
     * @return \Illuminate\Http\Response
     */
    public function archive(Message $message)
    {
        $this->authorize('archive', $message);

        $message->update(['status_id' => Message::STATUS_ARCHIVED]);

        return redirect()->route('inbox')->with(
            'info',
            sprintf('Message archived! 🗄 <br> %s', view('message.unarchive_button', ['message' => $message]))
        );
    }

    /**
     * Un-archive the message
     *
     * @return \Illuminate\Http\Response
     */
    public function unarchive(Message $message)
    {
        $this->authorize('unarchive', $message);

        $message->update(['status_id' => Message::STATUS_UNANSWERED]);

        return redirect()->route('inbox')->with('info', 'Message restored! 📬');
    }

    /**
     * Delete the message
     *
     * @return \Illuminate\Http\Response
     */
    public function delete(Message $message)
    {
        $this->authorize('delete', $message);

        $message->delete();

        return back()->with('info', 'Message deleted! 🗑');
    }
}
