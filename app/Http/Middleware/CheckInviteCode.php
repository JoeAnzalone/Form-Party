<?php

namespace App\Http\Middleware;

use Closure;
use \App\Invite;

class CheckInviteCode
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $invite_code = $request->get('invite');

        try {
            $invite = Invite::where('code', $invite_code)->where('claimed_by_id', null)->firstOrFail();
        } catch (\Exception $e) {
            return redirect('/');
        }

        $request->attributes->add(['invite' => $invite]);
        return $next($request);
    }
}
