Form Party
==========

This is the code that powers [Form.party](https://form.party)🎉

### Installation
1. Install [Composer](https://getcomposer.org/)
2. Run `composer install` to install dependencies
3. Copy `.env.example` to `.env`
4. Add database info to `.env`
5. Generate an app key: `php artisan key:generate`
6. Run migrations to create tables: `php artisan migrate`
7. Create a new invite code using `php artisan tinker`
```
$i = new \App\Invite();
$i->code = 'whatever';
$i->save();
```
8. Create your user by going to `/register?invite=whatever`

License
-------
Form Party is open-sourced software licensed under the [BSD 3-Clause license.](https://opensource.org/licenses/BSD-3-Clause)

Form Party uses the wonderful [Laravel PHP Framework](https://laravel.com), which is licensed under [the MIT license.](https://opensource.org/licenses/MIT)
