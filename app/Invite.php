<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Invite extends Model
{
    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->code = \Illuminate\Support\Str::random(32);
    }

    protected function getUrlAttribute()
    {
        return \URL::route('register', ['invite' => $this->code]);
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function claimed_by()
    {
        return $this->belongsTo('App\User');
    }
}
