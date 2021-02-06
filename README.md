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

To try this, first follow the following steps to set up Laravel:
1. Create a new Laravel project, say 'xyz', e.g.
```
$ composer create-project laravel/laravel xyz
```
1. Set up Vue.js scaffolding with login/authentication.
```
$ cd xyz
$ composer require laravel/ui:^2.4
$ php artisan ui vue --auth
$ npm install && npm run dev
```
1. Configure Laravel and run database migration.

Next, follow these steps to set up the employee case study:
1. Copy files from 'src' into the corresponding locations inside
   Laravel project 'xyz'.
1. Install Vue router and build the application.
```
$ cd xyz
$ npm install --save-dev vue-router
$ npm run dev
```
1. Run database migration again to create employee table, etc.
1. Create Laravel users, say 'john' and 'jane'.
```
$ cd xyz
$ php artisan tinker <<-'EOS'
	$user = new App\User();
	$user->name = 'john';
	$user->password = Hash::make('john1234');
	$user->email = 'john@example.com';
	$user->save();

	$user = new App\User();
	$user->name = 'jane';
	$user->password = Hash::make('jane1234');
	$user->email = 'jane@example.com';
	$user->save();
EOS
```
1. Make one of the users (say 'jane') an admin user; generate API token
   also for the SPA employee management page.
```
$ php artisan admin grant jane
$ php artisan api-token jane set
```
1. Load sample employee data, e.g.
```
$ php xyz/artisan employee:load-csv employee-data.csv
```
