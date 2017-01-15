<?php

namespace App\Validators;

class ReservedUsernameValidator
{
    /**
     * Validate the username to make sure it's not reserved
     *
     * @return bool
     */
    public function validate($attribute, $value, $parameters, $validator)
    {
        return !in_array(strtolower($value), $this->reserved_usernames);
    }

    protected $reserved_usernames = [
        'me',
        'you',
        'welcome',
        'home',
        'main',
        'index',
        'www',
        'install',
        'admin',
        'administrator',
        'pubsubhubbub',
        'callback',
        'api',
        'auth',
        'authorize',
        'tumblr',
        'wordpress',
        'google',
        'facebook',
        'twitter',
        'instagram',
        'flickr',
        'blog',
        'config',
        'setting',
        'settings',
        'option',
        'options',
        'about',
        'photo',
        'photos',
        'new',
        'upload',
        'uploads',
        'profile',
        'page',
        'pages',
        'user',
        'users',
        'inbox',
        'message',
        'messages',
        'feed',
        'xml',
        'rss',
        'json',
        'login',
        'logout',
        'register',
        'search',
        'invite',
        'invites',
        'follow',
        'dashboard',
        'dash',
        'page',
        'map',
        'maps',
        'tag',
        'tags',
        'tagged',
        'view',
        'static',
        'application',
        'tools',
        'system',
        'theme',
        'themes',
        'timezone',
    ];
}
