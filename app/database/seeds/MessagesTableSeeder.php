<?php

// Composer: "fzaninotto/faker": "v1.3.0"
use Faker\Factory as Faker;

class MessagesTableSeeder extends Seeder {

	public function run()
	{

		Message::create([
			'form' => 'login',
			'success' => 'Login successful',
			'error' => 'Incorrect username or password'
		]);

		Message::create([
			'form' => 'review',
			'success' => 'Review successfully submitted',
			'error' => 'One or more fields are incomplete'
		]);

		Message::create([
			'form' => 'contact',
			'success' => 'Your message has successfully been submitted',
			'error' => 'One or more fields are incomplete'
		]);

		Message::create([
			'form' => 'registration',
			'success' => 'You have successfully registered',
			'error' => 'One or more fields are incomplete'
		]);

		Message::create([
			'form' => 'password',
			'success' => 'Password request has been submitted',
			'error' => 'Email not found'
		]);
	
	}

}