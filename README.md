# sample-laravel-01
This is sample Laravel application code. I wrote this back in 2020 as
part of a job application. It is an employe database 'case study' with
the following features:

* Database migration for an 'employees' table and a console command
  'artisan employee:load-csv' to load employee data from CSV file.

* Basic user management with regular users and admin users. Console
  command 'artisan admin ...' to manage admin users.

* Employee directory page and details page for authenticated users.

* Employee management page (CRUD) for admin users only.

* Single page app version of the employee management page using API.

It was originally written for Laravel version 6.3.0. The instructions
below assume 7.30.4 or compatible.

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
