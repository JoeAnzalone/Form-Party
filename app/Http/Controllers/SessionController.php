<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Session;
use Carbon\Carbon;

class SessionController extends Controller
{
    public function setTimezone(Request $request)
    {
        $gmt_offset = (int) $request->input('gmt_offset');

        if (!$request->has('gmt_offset')) {
            abort(400, 'No GMT offset set');
        }

        $timezone = $gmt_offset ?: 'GMT';

        try {
            // Validate to make sure this is a valid timezone
            $time = Carbon::createFromTimestamp(0, $timezone);
        } catch (\Exception $e) {
            abort(400, 'Not a valid GMT offset');
        }

        Session::set('gmt_offset', $gmt_offset);
        Session::set('timezone', $timezone);
    }
}
