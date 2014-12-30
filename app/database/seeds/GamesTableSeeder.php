<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GamesTableSeeder extends Seeder {

	public function run()
	{
		DB::table('games')->delete();
		
		DB::table('games')->insert(array(
			array(
				'user_id' => 1,
				'main_title' => 'Blazing Cloud',
				'slug' => 'blazing-cloud',
				'default_price' => '20.00',
				'featured' => 1
			),

			array(
				'user_id' => 1,
				'main_title' => 'Blazing Dribble',
				'slug' => 'blazing-dribble',
				'default_price' => '20.00',
				'featured' => 1
			),

			array(
				'user_id' => 1,
				'main_title' => 'Blazing Kickoff',
				'slug' => 'blazing-kickoff',
				'default_price' => '20.00',
				'featured' => 1
			),

			array(
				'user_id' => 1,
				'main_title' => 'Doraemon',
				'slug' => 'doraemon',
				'default_price' => '30.00',
				'featured' => 1
			),

			array(
				'user_id' => 1,
				'main_title' => 'Mew Mew Tower',
				'slug' => 'mew-mew-tower',
				'default_price' => '10.00',
				'featured' => 1
			),

			array(
				'user_id' => 1,
				'main_title' => 'Pop Up Pirates',
				'slug' => 'pop-up-pirates',
				'default_price' => '70.00',
				'featured' => 1
			)
		));
	}

}
