<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateSaleGamesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('sale_games', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('game_id')->unsigned()->index();
            $table->foreign('game_id')->references('id')->on('games')->onDelete('cascade');
            $table->integer('carrier_id')->unsigned()->index();
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('cascade');
            $table->float('price');
            $table->date('start_date');
            $table->date('end_date');
            $table->boolean('sale_active');
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
		Schema::drop('sale_games');
	}

}
