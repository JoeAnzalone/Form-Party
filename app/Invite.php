<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected function getUrlAttribute()
    {
        return \URL::route('register', ['invite' => $this->code]);
    }
}
