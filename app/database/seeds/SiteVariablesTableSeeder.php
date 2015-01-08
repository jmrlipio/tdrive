<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class SiteVariablesTableSeeder extends Seeder {

	public function run()
	{

		SiteVariable::create([
			'variable_name' => 'Facebook',
			'variable_value' => 'https://www.facebook.com/tosesoft'
		]);

		SiteVariable::create([
			'variable_name' => 'Twitter',
			'variable_value' => 'http://twitter.com'
		]);

		SiteVariable::create([
			'variable_name' => 'Google Analytics',
			'variable_value' => 'https://www.google.com/'
		]);

		SiteVariable::create([
			'variable_name' => 'Tose Link',
			'variable_value' => 'ToseSoft'
		]);

		SiteVariable::create([
			'variable_name' => 'Japan Link',
			'variable_value' => 'JP Link'
		]);

		SiteVariable::create([
			'variable_name' => 'Philippines Link',
			'variable_value' => 'PH Link'
		]);

		SiteVariable::create([
			'variable_name' => 'Support Link',
			'variable_value' => 'support@tdrive.co'
		]);

	}

}