<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CategoriesTableSeeder extends Seeder {

	public function run()
	{
		$categories = [
			"brain-and-puzzle"	=> "Brain and Puzzle",
			"casual"			=> "Casual",
			"arcade"			=> "Arcade",
			"cards-and-casino"	=> "Cards and Casino",
			"classic"			=> "Classic",
			"sanrio"			=> "Sanrio"
		];

		foreach($categories as $key => $value)
		{
			Category::create([
				"category" 	=> $value,
				"slug"		=> $key,
				"featured"  => rand(0,1)
			]);
		}
	}

}