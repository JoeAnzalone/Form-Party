<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');

        if (config('app.invite_only', false)) {
            $this->middleware('invited');
        }
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, User::validationRules());
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return User
     */
    protected function create(array $data)
    {
        $user = User::create([
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'name' => '',
        ]);

        if (!empty($data['invite_code'])) {
            $invite_code = $data['invite_code'];
            $invite = \App\Invite::where('code', $invite_code)->where('claimed_by_id', null)->firstOrFail();
            $user->inviteUsed()->save($invite);
        }

        return $user;
    }

    /**
     * Show the application registration form.
     *
     * @return \Illuminate\Http\Response
     */
     public function showRegistrationForm(Request $request)
     {
        $invite = $request->attributes->get('invite');

        $alert = false;
        if ($invite) {
            if ($invite->user) {
                $alert = sprintf(
                    '<a target="_blank" href="%s">%s</a> has invited you to check out %s!',
                    route('profile', $invite->user->username),
                    $invite->user->username,
                    config('app.name')
                );
            } else {
                $alert = sprintf(
                    'You\'ve been invited you to check out %s!',
                    config('app.name')
                );
            }
        }

        return view('auth.register', ['title' => 'Register', 'invite' => $invite, 'info' => $alert]);
     }

    /**
     * Handle a registration request for the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        event(new Registered($user = $this->create($request->all())));

        $this->guard()->login($user, true);

        return $this->registered($request, $user)
            ?: redirect($this->redirectPath());
    }
}
