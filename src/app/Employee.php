<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Employee extends Model
{
	/** @var array Guarded attributes. */
	protected $guarded = [
		'id',
	];
}

// vim: set ts=4 noexpandtab syntax=php:
