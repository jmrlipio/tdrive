<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateFaqLanguagesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('faq_languages', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('language_id')->unsigned();
			$table->foreign('language_id')->references('id')->on('languages')->onDelete('cascade');
			$table->integer('faq_id')->unsigned()->index();
            $table->foreign('faq_id')->references('id')->on('faqs')->onDelete('cascade');
			$table->string('question');
			$table->text('answer');
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
		Schema::drop('faq_languages');
	}

}
