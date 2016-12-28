<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FormController extends Controller
{
    /**
     * Show the form.
     *
     * @return \Illuminate\Http\Response
     */
    public function show(string $username)
    {
        $user = \App\User::where('username', $username)->firstOrFail();

        return view('form.show', ['user' => $user]);
    }
}
