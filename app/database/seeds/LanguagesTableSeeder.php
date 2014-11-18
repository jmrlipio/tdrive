<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class LanguagesTableSeeder extends Seeder {

	public function run()
	{
		$languages = [
			"English",
			"Thai",
			"Bahasa Indonesia",
			"Bahasa Malaysia",
			"Traditional Chinese",
			"Simplified Chinese",
			"Vietnamese",
			"Japanese",
			"Hindi"
		];

		foreach($languages as $language)
		{
			Language::create([
				"language" => $language
			]);
		}
	}

}