<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class PlatformsTableSeeder extends Seeder {

	public function run()
	{
		$platforms = [
			"android"	=> "Android",
			"ios"		=> "iOS"
		];

		foreach($platforms as $key => $value)
		{
			Platform::create([
				"platform" 	=> $value,
				"slug"		=> $key
			]);
		}
	}

}