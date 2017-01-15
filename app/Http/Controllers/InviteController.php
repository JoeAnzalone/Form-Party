<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;

class InviteController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the user's list of invite codes.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user->has_invites) {
            abort(404);
        }

        $all_invites = $user->invites()->with('claimed_by')->get();

        $invites = [
            'unused' => $all_invites->where('name', null)->where('claimed_by_id', null),
            'pending' => $all_invites->where('name', '<>', null)->where('claimed_by_id', null),
            'claimed' => $all_invites->where('claimed_by_id', '<>', null),
        ];

        return view('user.invites', ['title' =>  'Invite', 'page' => 'invite', 'invites' => $invites]);
    }

    /**
     * Attach a name to a pre-made invite code, and reveal it to the user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $user = Auth::user();

        $invite = $user->invites()->where('name', null)->where('claimed_by_id', null)->first();

        if (trim($request->name) && $invite) {
            $invite->update(['name' => $request->name]);
            return redirect()->route('invite')->with([
                'invite_created' => ['name' => $invite->name, 'url' => $invite->url]
            ]);
        }

        return redirect()->route('invite')->withErrors(['name' => 'Something went wrong :(']);
    }
}
