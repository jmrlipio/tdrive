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
				'message' 	=> $faker->text($maxNbChars = 70),
			]);
		}
	}

}