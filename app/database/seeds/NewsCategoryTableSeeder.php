<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class NewsCategoryTableSeeder extends Seeder {

	public function run()
	{
		$news_category = [
			"news"			=> "News", 
			"announcement"	=> "Announcement",
			"alert"			=> "Alert"
		];

		foreach($news_category as $key => $value)
		{
			NewsCategory::create([
				"category"	=> $value,
				"slug"		=> $key
			]);
		}
	}

}