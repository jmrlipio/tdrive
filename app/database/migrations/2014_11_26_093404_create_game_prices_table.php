<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateGamePricesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('game_prices', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('game_id')->unsigned();
			$table->foreign('game_id')->references('id')->on('games');
			$table->integer('carrier_id')->unsigned();
			$table->foreign('carrier_id')->references('id')->on('carriers');
			$table->integer('country_id');
			$table->foreign('country_id')->references('id')->on('countries');
			$table->float('price');
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
		Schema::drop('game_prices');
	}

}
