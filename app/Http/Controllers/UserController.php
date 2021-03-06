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
     * Show the list of all users
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->authorize('index', User::class);

        $users = User::paginate(20);

        return view('user.all', [
            'users' => $users,
        ]);
    }

    /**
     * Show the user's profile.
     *
     * @return \Illuminate\Http\Response
     */
    public function profile(User $user)
    {
        $messages = $user->messages()->where('status_id', Message::STATUS_ANSWERED_PUBLICLY)->orderBy('answered_at', 'desc')->orderBy('updated_at', 'desc')->paginate(10);

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
            'page' => 'profile',
            'title' =>  $title,
            'og' =>  $open_graph,
            'user' => $user,
            'messages' => $messages,
        ]);
    }

    /**
     * Show the list of users this user follows
     *
     * @return \Illuminate\Http\Response
     */
    public function following(User $user)
    {
        $users = $user->following;

        return view('user.following', [
            'page' => 'following',
            'user' => $user,
            'users' => $users,
        ]);
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
        Auth::user()->follow($user);

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
        Auth::user()->unfollow($user);
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


        $meta = $user->meta;

        $meta['notifications'] = [
            'new_message' => ['email' => !empty($user_params['new_message_email'])],
            'new_follower' => ['email' => !empty($user_params['new_follower_email'])],
            'invitation_accepted' => ['email' => !empty($user_params['invitation_accepted_email'])],
        ];

        $user_params['meta'] = $meta;

        $user->update($user_params);

        return redirect()->route('profile', $user->username)->with('success', 'Saved! 💾');
    }
}
