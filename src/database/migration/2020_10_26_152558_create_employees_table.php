<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmployeesTable extends Migration
{
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('employees', function (Blueprint $table) {
			$table->bigIncrements('id');
			$table->timestamps();
			$table->string('name_prefix', 7)->nullable();
			$table->string('first_name');
			$table->char('middle_initial', 1)->nullable();
			$table->string('last_name');
			$table->char('gender', 1);
			$table->string('email')->unique();
			$table->string('fathers_name');
			$table->string('mothers_name');
			$table->string('mothers_maiden_name');
			$table->date('date_of_birth');
			$table->date('date_of_joining');
			$table->decimal('salary', 10, 2);
			$table->string('ssn')->unique();
			$table->string('phone_no');
			$table->string('city');
			$table->char('state', 2);
			$table->string('zip', 5);

			$table->index([
				'last_name',
				'first_name',
			]);
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists('employees');
	}
}

// vim: set ts=4 noexpandtab syntax=php:
