<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class GeneralSettingsTableSeeder extends Seeder {

	public function run()
	{
		GeneralSetting::create([
			'setting' => 'Site Name',
			'value'   => 'TDrive'
		]);

		GeneralSetting::create([
			'setting' => 'Site Slogan',
			'value'   => 'TDrive For Life'
		]);
		
		GeneralSetting::create([
			'setting' => 'Meta',
			'value'   => 'Meta Values'
		]);

		GeneralSetting::create([
			'setting' => 'Date Format',
			'value'   => 'yyyy-m-d'
		]);
	}

}