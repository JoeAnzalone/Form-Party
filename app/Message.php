<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Message extends Model
{
    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    const STATUS_UNANSWERED = 0;
    const STATUS_ANSWERED_PUBLICLY = 1;

    protected function getStatusAttribute()
    {
        $statuses = [
            self::STATUS_UNANSWERED => 'unanswered',
            self::STATUS_ANSWERED_PUBLICLY => 'answered_publicly',
        ];

        return $statuses[$this->status_id];
    }

    protected function recipient()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
