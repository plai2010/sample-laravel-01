<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

use App\EmployeeImport;
use App\User;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('admin
	{ action : grant|revoke|list }
	{ name? : Name of user (required unless list action) }
', function($action, $name=null) {
	if ($action != 'list') {
		$user = User::where('name', $name)->first();
		if (!$user) {
			$this->error("Unknown user: $name");
			return;
		}
	}
	switch ($action) {
	case 'list':
		foreach (User::where('admin', true)->orderBy('name')->get() as $admin) {
			$this->info($admin->name);
		}
		return;
	case 'grant':
		if ($user->admin) {
			$this->error("User '$name' is already an admin");
			return;
		}
		$user->admin = true;
		$done = 'granted';
		break;
	case 'revoke':
		if (!$user->admin) {
			$this->error("User '$name' is not an admin");
			return;
		}
		$user->admin = false;
		$done = 'revoked';
		break;
	default:
		$this->error("Invalid action '$action'");
		return;
	}

	try {
		if (!$user->save())
			throw new Exception('User::save() failed');
	}
	catch (Exception $ex) {
		$this->error("Failed to $action admin privileges: $name");
		return;
	}

	$this->info("Admin privileges $done: $name");
})->describe('Manage admin users');

Artisan::command('api-token
	{ name : Name of user }
	{ action : delete|set }
	{ token? : Token value to set if not to be generated }
', function($name, $action, $token=null) {
	$user = User::where('name', $name)->first();
	if (!$user) {
		$this->error("Unknown user: $name");
		return;
	}
	switch ($action) {
	case 'delete':
		$user->api_token = null;
		$done = 'deleted';
		break;
	case 'set':
		if ($token == '')
			$token = Str::random(80);
		$user->api_token = $token;
		$done = 'updated';
		break;
	default:
		$this->error("Invalid action '$action'");
		return;
	}
	try {
		if (!$user->save())
			throw new Exception('User::save() failed');
	}
	catch (Exception $ex) {
		$this->error("Failed to $action API token of user '$name'");
		return;
	}
	$this->info("API token of user '$name' $done");
})->describe('Manage API tokens');

Artisan::command('employee:load-csv
	{ path : Employee CSV file with header line }
', function($path) {
	$this->info("Loading employee records from '$path' ...");
	$loaded = EmployeeImport::loadCsv($path);
	$this->info("$loaded records loaded.");
})->describe('Load employee data from CSV file');

// vim: set ts=4 noexpandtab syntax=php:
