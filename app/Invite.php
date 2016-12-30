<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    protected function getUrlAttribute()
    {
        return \URL::route('register', ['invite' => $this->code]);
    }

    public function claimed_by()
    {
        return $this->belongsTo('App\User');
    }
}
