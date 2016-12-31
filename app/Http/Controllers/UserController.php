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
        $messages = $user->messages->where('status_id', Message::STATUS_ANSWERED_PUBLICLY)->sortByDesc('updated_at');

        $title = sprintf('%s Form Party', $user->username_possessive);

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
