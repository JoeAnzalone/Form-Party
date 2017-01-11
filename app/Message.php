<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Session;
use Carbon\Carbon;

class Message extends Model
{
    use SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'status_id',
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at', 'answered_at'];

    const STATUS_UNANSWERED = 0;
    const STATUS_ANSWERED_PUBLICLY = 1;
    const STATUS_ARCHIVED = 2;

    public function getCreatedAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return Carbon::createFromFormat($this->getDateFormat(), $value)->timezone(Session::get('timezone', 'America/New_York'));
    }

    public function getAnsweredAtAttribute($value)
    {
        if (empty($value)) {
            return null;
        }

        return Carbon::createFromFormat($this->getDateFormat(), $value)->timezone(Session::get('timezone', 'America/New_York'));
    }

    protected function getStatusAttribute()
    {
        $statuses = [
            self::STATUS_UNANSWERED => 'unanswered',
            self::STATUS_ANSWERED_PUBLICLY => 'answered_publicly',
        ];

        return $statuses[$this->status_id];
    }

    protected function getisPublicAttribute()
    {
        return $this->status_id === self::STATUS_ANSWERED_PUBLICLY;
    }

    public function recipient()
    {
        return $this->belongsTo('App\User', 'user_id');
    }
}
