<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;

class CreateDiscountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('discounts', function(Blueprint $table)
		{
			$table->increments('id');
			$table->integer('carrier_id')->unsigned();
			$table->foreign('carrier_id')->references('id')->on('carriers');
			$table->string('title');
			$table->text('description');
            $table->float('discount_percentage');
            $table->date('start_date');
            $table->date('end_date');
            $table->string('featured_image');
            $table->boolean('active');
            $table->integer('user_limit');
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
		Schema::drop('discounts');
	}

}
