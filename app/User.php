<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    const ROLE_ID_NONE = 0;
    const ROLE_ID_ADMIN = 1;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'username', 'password', 'website', 'bio',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The validation rules for this model
     *
     * @return array
     */
    public static function validationRules()
    {
        $user = \Auth::user();
        $min_str = !($user && $user->is_admin) ? 'min:4|' : '';

        $rules = [
            'username' => 'required|alpha_num|' . $min_str . 'max:32|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];

        return $rules;
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function getUnansweredMessageCountAttribute()
    {
        return $this->messages->where('status_id', Message::STATUS_UNANSWERED)->count();
    }

    public function invites()
    {
        return $this->hasMany('App\Invite');
    }

    public function inviteUsed()
    {
        return $this->hasMany('App\Invite', 'claimed_by_id');
    }

    public function getHasInvitesAttribute()
    {
        return ($this->invites->count());
    }

    public function getUsernamePossessiveAttribute()
    {
        return sprintf(
            '%s%s',
            $this->username,
            ends_with($this->username, 's') ? "'" : "'s"
        );
    }

    public function setWebsiteAttribute(string $url)
    {
        if (!starts_with($url, 'http://') && !starts_with($url, 'https://')) {
            $url = 'http://' . $url;
        }

        $this->attributes['website'] = $url;
    }

    public function getShortWebsiteAttribute()
    {
        $url = $this->website;

        if (starts_with($url, 'http://')) {
            $url = substr($url, 7);
        } elseif (starts_with($url, 'https://')) {
            $url = substr($url, 8);
        }

        if (starts_with($url, 'www.')) {
            $url = substr($url, 4);
        }

        return $url;
    }

    public function getisAdminAttribute()
    {
        return $this->role_id === self::ROLE_ID_ADMIN;
    }

    private function getEmailHash()
    {
        $email = trim($this->email);
        $email = strtolower($email);
        return md5($email);
    }

    public function avatar($size = 80)
    {

        $query_string = http_build_query([
            'd' => 'monsterid',
            's' => $size,
        ]);

        return 'https://www.gravatar.com/avatar/' . $this->getEmailHash() . '?' . $query_string;
    }

    public function getGravatarProfileUrlAttribute()
    {
        return 'https://www.gravatar.com/' . $this->getEmailHash();
    }
}
