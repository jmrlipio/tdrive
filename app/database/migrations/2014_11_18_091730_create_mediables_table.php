<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateMediablesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('mediables', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('media_id')->unsigned();
			$table->foreign('media_id')->references('id')->on('media');
			$table->morphs('mediable');
			$table->string('type');
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
		Schema::drop('mediables');
	}

}
