<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateNewsContentsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('news_contents', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('language_id')->unsigned();
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
			$table->integer('news_id')->unsigned();
			$table->foreign('news_id')->references('id')->on('news')->onDelete('cascade');
			$table->string('title');
			$table->text('content');
			$table->string('excerpt');
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
		Schema::drop('news_contents');
	}

}
