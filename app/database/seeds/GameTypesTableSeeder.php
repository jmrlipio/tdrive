<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GameTypesTableSeeder extends Seeder {

	public function run()
	{
		$type = ['Arcade', 'Adventure', 'Brain and Puzzle', 'Classic', 'Casual', 'Cards and Casino'];

		foreach(range(0, 5) as $index)
		{
			GameType::create([
				'name' => $type[$index]
			]);
		}
	}

}