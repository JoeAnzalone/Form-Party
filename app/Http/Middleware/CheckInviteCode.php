<?php

namespace App\Http\Middleware;

use Closure;

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

        // TODO: Create an Invite object and check if it's unclaimed
        $invite = ['code' => $invite_code];

        if (!$invite_code) {
            return redirect('/')->with(['error' => 'wow']);
        }

        $request->attributes->add(['invite' => $invite]);
        return $next($request);
    }
}
