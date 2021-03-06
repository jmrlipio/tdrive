<?php

class DatabaseSeeder extends Seeder {

	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		Eloquent::unguard();

		$this->call('UsersTableSeeder');
		$this->call('LanguagesTableSeeder');
		$this->call('NewsCategoryTableSeeder');
		$this->call('CategoriesTableSeeder');
		$this->call('CountriesSeeder');
		// $this->call('FaqsTableSeeder');
		$this->call('InquiriesTableSeeder');
		$this->call('GeneralSettingsTableSeeder');
		$this->call('SiteVariablesTableSeeder');
		$this->call('GameSettingsTableSeeder');
		$this->call('MessagesTableSeeder');
		// $this->call('GamesTableSeeder');
	}

}
