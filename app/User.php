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
        'name', 'email', 'username', 'password', 'website', 'bio', 'meta',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'email',
    ];

    /**
     * The default meta field values
     *
     * @var array
     */
    public $defaults = [
        'meta' => [
            'notifications' => [
                'new_message' => ['email' => true],
                'new_follower' => ['email' => true],
                'invitation_accepted' => ['email' => true],
            ],
            'permissions' => [
                'short_username' => false,
            ],
        ],
    ];

    /**
     * Get the route key for the model.
     *
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'username';
    }

    /**
     * The validation rules for this model
     *
     * @return array
     */
    public static function validationRules()
    {
        $user = \Auth::user();
        $min_str = !($user && $user->can('shortUsername', User::class)) ? 'min:4|' : '';

        $rules = [
            'username' => 'reserved_username|required|alpha_num|' . $min_str . 'max:32|unique:users,username',
            'email' => 'required|email|max:255|unique:users,email',
            'password' => 'required|min:6|confirmed',
        ];

        return $rules;
    }

    public function givePermission(string $permission)
    {
        $meta = $this->meta;
        $meta['permissions'][$permission] = true;
        return $this->update(['meta' => $meta]);
    }

    public function revokePermission(string $permission)
    {
        $meta = $this->meta;
        $meta['permissions'][$permission] = false;
        return $this->update(['meta' => $meta]);
    }

    public function follow(User $user, bool $raise_event = true)
    {
        $this->following()->attach($user);

        if ($raise_event) {
            event(new \App\Events\FollowCreated($this, $user));
        }
    }

    public function unfollow(User $user)
    {
        $this->following()->detach($user);
        // event(new \App\Events\FollowRemoved($this, $user));
    }

    public function followers()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'followed_id', 'follower_id');
    }

    public function following()
    {
        return $this->belongsToMany('App\User', 'user_follows', 'follower_id', 'followed_id');
    }

    public function messages()
    {
        return $this->hasMany('App\Message');
    }

    public function getUnansweredMessageCountAttribute()
    {
        if (!isset($this->attributes['unanswered_message_count'])) {
            $this->attributes['unanswered_message_count'] = $this->messages->where('status_id', Message::STATUS_UNANSWERED)->count();
        }

        return $this->attributes['unanswered_message_count'];
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
        if (!empty($url) && !starts_with($url, 'http://') && !starts_with($url, 'https://')) {
            $url = 'http://' . $url;
        }

        $this->attributes['website'] = $url;
    }

    public function getMetaAttribute()
    {
        $meta = json_decode($this->attributes['meta'], true) ?: [];
        return array_replace_recursive($this->defaults['meta'], $meta);
    }

    public function setMetaAttribute(array $meta)
    {
        $meta = array_replace_recursive($this->defaults['meta'], $meta);
        $this->attributes['meta'] = json_encode($meta);
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

    public function avatarImg($size = 80, $imgSize = null, $hyperlink = true)
    {
        $imgSize = $imgSize ?: $size;

        $img = sprintf(
            '<img src="%s" width="%d" height="%d" alt="%s avatar">',
            e($this->avatar($size)),
            $imgSize,
            $imgSize,
            e($this->username_possessive)
        );

        if ($hyperlink) {
            return sprintf('<a href="%s">%s</a>', $this->url, $img);
        }

        return $img;
    }

    public function getUrlAttribute()
    {
        return route('profile', $this);
    }

    public function getGravatarProfileUrlAttribute()
    {
        return 'https://www.gravatar.com/' . $this->getEmailHash();
    }
}
