<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateCountryCarriersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('country_carriers', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('country_id')->index();
			$table->foreign('country_id')->references('id')->on('countries');
            $table->integer('carrier_id')->unsigned()->index();
            $table->foreign('carrier_id')->references('id')->on('carriers')->onDelete('cascade');
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
		Schema::drop('country_carriers');
	}

}
