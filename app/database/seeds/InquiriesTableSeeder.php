<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class InquiriesTableSeeder extends Seeder {

	public function run()
	{
		$faker = Faker::create();
		foreach(range(1, 10) as $index)
		{
			Inquiry::create([
				'name' 		=> $faker->name,
				'email'		=> $faker->email,
				'game_title' 	=> $faker->text($maxNbChars = 15),
				'message' 	=> $faker->text($maxNbChars = 70),
			]);
		}
	}

}