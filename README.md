# sample-laravel-01
This is sample Laravel application code. I wrote this back in 2020 as
part of a job application. It was originally for Laravel version 6.3.0.
The instructions below assume 7.30.4 or compatible.

To try this, follow the following steps:
1. Create a new Laravel project, say 'xyz', e.g.
```
$ composer create-project laravel/laravel xyz
```
1. Set up Vue.js scaffolding with login/authentication, e.g. inside 'xyz'
```
$ composer require laravel/ui:^2.4
$ php artisan ui vue --auth
$ npm install && npm run dev
```
1. Configure Laravel and run database migration.
