<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
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
}
