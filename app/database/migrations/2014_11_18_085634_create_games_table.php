<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('games', function(Blueprint $table)
		{
			$table->integer('id')->unsigned();
			$table->primary('id');
			$table->integer('user_id')->unsigned();
			$table->foreign('user_id')->references('id')->on('users');
			$table->integer('carrier_id')->unsigned();
			$table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('cascade')->onUpdate('cascade');
			$table->string('main_title');
			$table->string('slug');
			$table->float('default_price');
			$table->string('status');
			$table->boolean('featured');
			$table->date('release_date');
			$table->integer('downloads');
			$table->integer('actual_downloads');
			$table->string('image_orientation');
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
		Schema::drop('games');
	}

}
