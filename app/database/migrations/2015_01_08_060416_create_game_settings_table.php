<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGameSettingsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_settings', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('game_thumbnails');
			$table->integer('game_rows');
			$table->integer('game_reviews');
			$table->integer('review_rows');
			$table->string('ribbon_url');
			$table->string('sale_url');
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
		Schema::drop('game_settings');
	}

}
