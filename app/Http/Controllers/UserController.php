<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\User;
use App\Message;

class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth', ['except' => 'profile']);
    }

    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(string $username)
    {
        $user = User::where('username', $username)->firstOrFail();
        $messages = $user->messages()->where('status_id', Message::STATUS_ANSWERED_PUBLICLY)->orderBy('updated_at', 'desc')->paginate(10);

        $title = sprintf('%s Form Party', title_case($user->username_possessive));

        $open_graph = [
            'og:title' => $title . ' 🎉',
            'og:description' => sprintf('Send %s a message — anonymously! It\'s like a party 🎊', $user->username),
            'og:site_name' => config('app.name'),
            'og:image' => $user->avatar(200),
            'og:url' => route('profile', $user->username),
            'og:type' => 'profile',
            'profile:username' => $user->username,
        ];

        return view('user.profile', [
            'title' =>  $title,
            'og' =>  $open_graph,
            'user' => $user,
            'messages' => $messages,
        ]);
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

    /**
     * Show the User settings screen
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $user = \Auth::user();

        return view('user.settings', ['title' =>  'Settings', 'user' => $user]);
    }

    /**
     * Save the User settings
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSettings(Request $request)
    {
        $user = \Auth::user();

        $rules = User::validationRules();
        $rules['email'] = $rules['email'] . ',' . $user->id;
        $rules['username'] = $rules['username'] . ',' . $user->id;
        unset($rules['password']);

        Validator::make($request->all(), $rules)->validate();

        $user->fill($request->all())->save();

        return redirect()->route('settings')->with('success', '💾 Saved!');
    }
}
