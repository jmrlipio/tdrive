<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GameCategoriesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('game_categories')->delete();
		
		DB::table('game_categories')->insert(array(
			array(
				'game_id' => 25,
				'category_id' => 5
			),

			array(
				'game_id' => 26,
				'category_id' => 5
			),

			array(
				'game_id' => 27,
				'category_id' => 5
			),

			array(
				'game_id' => 28,
				'category_id' => 5
			),

			array(
				'game_id' => 29,
				'category_id' => 5
			),

			array(
				'game_id' => 30,
				'category_id' => 5
			),

		));
	}

}
