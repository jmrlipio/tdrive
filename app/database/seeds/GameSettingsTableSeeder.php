<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GameSettingsTableSeeder extends Seeder {

	public function run()
	{
		GameSetting::create([
			'game_thumbnails' => 3,
			'game_rows' => 5,
			'game_reviews' => 3,
			'review_rows' => 5,
			'ribbon_url' => 'ribbon.png'
		]);
	}

}