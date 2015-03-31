<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('users', function(Blueprint $table)
		{
			$table->increments('id');
			$table->string('username')->unique();
			$table->string('password', 64);
			$table->string('email');
			$table->string('first_name');
			$table->string('last_name');
			$table->string('remember_token', 100)->nullable();
			$table->dateTime('last_login');
			$table->string('role');
			$table->string('prof_pic');
			$table->string('code');
			$table->string('mobile_no');
			$table->integer('active')->default(0);
			$table->timestamps();
		});
	}


	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('users');
	}

}
