<?php

class FaqsTableSeeder extends Seeder {

	public function run()
	{

		Faq::create([
			'question' => 'How do we pay for the games?',
			// 'answer' => 'It is easy to pay for the games using TDrive. On your mobile browser, click "Buy" on the game that you want to purchase. You will then be redirected to the carrier that supports TDrive. You can then purchase the game using carrier credit.',
			'order' => '1'
		]);

		Faq::create([
			'question' => 'What sets TDrive apart from iTunes and Google Play?',
			// 'answer' => 'You don\'t need a credit card or other payment gateways when you use TDrive. You can pay using your carrier. You can also purchase in game items using this method.',
			'order' => '2'
		]);

		Faq::create([
			'question' => 'Which countries are being serviced by TDrive?',
			// 'answer' => 'As of now TDrive is present in the Philippines and Indonesia. More countries will be added soon.',
			'order' => '3'
		]);

		Faq::create([
			'question' => 'How do we send feedback and suggestions?',
			// 'answer' => 'We appreciate your comments and suggestions. Please send them to info@tdrive.co',
			'order' => '4'
		]);

		Faq::create([
			'question' => 'How do I purchase items from Item Mall/Shop?',
			// 'answer' => 'Just click the in-game item you want and purchase inside the game\'s shop. If the item is premium, you can buy this using your telco credits.',
			'order' => '5'
		]);

		Faq::create([
			'question' => 'How do I download past purchases?',
			// 'answer' => 'You can contact your carrier for assistance in this. If not, please send us an email and we\'ll be glad to help.',
			'order' => '6'
		]);

		Faq::create([
			'question' => 'Does TDrive have plans on selling iOS games?',
			// 'answer' => 'Yes. It\'s part of our plan to release to all major mobile platforms including Android and iOS. Check our News regularly for updates.',
			'order' => '7'
		]);

		Faq::create([
			'question' => 'How can I check if the game works on my device before I purchase it?',
			// 'answer' => 'TDrive makes it a point to make all our games compatible with all devices. However, since there are different Android devices with different specs available in the market, this is sometimes hard to do. Please read the game’s description first before purchasing. If this does not help, please contact us.',
			'order' => '8'
		]);

	}

}
