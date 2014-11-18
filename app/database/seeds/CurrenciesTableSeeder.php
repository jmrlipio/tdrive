<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class CurrenciesTableSeeder extends Seeder {

	public function run()
	{
		$currencies = [
			"Philippines"   => "Philippine Peso",
			"Thailand"   	=> "Thai Bah",
			"Indonesia"   	=> "Indonesian Rupiah",
			"Malaysia"   	=> "Malaysian Ringgit",
			"Japan"   		=> "Japanese Yen",
			"Vietnam"   	=> "Vietnamese Dong",
			"India"   		=> "Indian Rupee"
		];

		foreach($currencies as $key => $value)
		{
			Currency::create([
				"country" 	=> $key,
				"currency"	=> $value
			]);
		}
	}

}