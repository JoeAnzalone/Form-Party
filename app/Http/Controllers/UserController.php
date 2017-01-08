<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Auth;
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
    public function profile(User $user)
    {
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
        $user = Auth::user();
        if (!$user->has_invites) {
            abort(404);
        }

        $invites = $user->invites;
        return view('user.invites', ['title' =>  'Invite', 'page' => 'invite', 'invites' => $invites]);
    }

    /**
     * Show the User settings screen
     *
     * @return \Illuminate\Http\Response
     */
    public function settings()
    {
        $user = Auth::user();

        return view('user.settings', ['title' =>  'Settings', 'user' => $user, 'page' => 'settings']);
    }

    /**
     * Follow this user
     *
     * @return \Illuminate\Http\Response
     */
    public function follow(User $user)
    {
        $this->authorize('follow', $user);
        Auth::user()->following()->attach($user);

        $emojis = ['👭', '👬', '👫'];
        $emoji = $emojis[array_rand($emojis)];

        return redirect()->route('profile', $user->username)->with('success', sprintf('You\'re now following %s! %s', $user->username, $emoji));
    }

    /**
     * Unfollow this user
     *
     * @return \Illuminate\Http\Response
     */
    public function unfollow(User $user)
    {
        $this->authorize('unfollow', $user);
        Auth::user()->following()->detach($user);
        return redirect()->route('profile', $user->username)->with('success', sprintf('You unfollowed %s! 🙅', $user->username));
    }

    /**
     * Save the User settings
     *
     * @return \Illuminate\Http\Response
     */
    public function saveSettings(Request $request)
    {
        $user = Auth::user();

        $rules = User::validationRules();
        $rules['email'] = $rules['email'] . ',' . $user->id;
        $rules['username'] = $rules['username'] . ',' . $user->id;

        $user_params = $request->all();

        $change_password = (!empty($user_params['password']) || !empty($user_params['password-confirm']));
        $change_email = ($user_params['email'] !== $user->email);

        if (!$change_password) {
            unset($rules['password']);
            unset($user_params['password']);
        }

        $validator = Validator::make($user_params, $rules)->validate();

        if ($change_password || $change_email) {
            if (!\Hash::check($user_params['current-password'], $user->password)) {
                return redirect()->route('settings')->with('error', 'Wrong password, bucko');
            }
        }

        if ($change_password) {
            $user_params['password'] = bcrypt($user_params['password']);
        }

        $user_params['meta'] = [
            'notifications' => [
                'new_message' => ['email' => !empty($user_params['new_message_email'])],
                'invitation_accepted' => ['email' => !empty($user_params['invitation_accepted_email'])],
            ],
        ];

        $user->update($user_params);

        return redirect()->route('profile', $user->username)->with('success', 'Saved! 💾');
    }
}
