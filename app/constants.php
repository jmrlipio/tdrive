<?php
namespace Constantine;
/*
	Constants, Globals
*/
class Constant {

	/*
		option table constants
	*/

	const API_PURCHASE_STATUS = 'http://106.187.43.219/tdrive_api/purchase_status.php?uuid=%s&app_id=%s';
	const API_DOWNLOAD_GAME = 'http://106.187.43.219/tdrive_api/download.php?transaction_id=%s&receipt=%s&uuid=%s';
	const API_PROCESS_BILLING = 'http://106.187.43.219/tdrive_api/process_billing.php?app_id=%s&uuid=%s&price=%s';

	const INQUIRY_EMAIL_SUBJECT = 'inquiry email subject';
	const INQUIRY_EMAIL_MESSAGE = 'inquiry email message';

	const LOGS_OPTIONS_CREATE = '%s created %s from inquiry settings on %s';
	const LOGS_OPTIONS_UPDATE = '%s updated %s from inquiry settings on %s';
	const LOGS_USERS_CREATE = '%s created a new user on %s';
	const LOGS_USERS_UPDATE = '%s updated a user on %s';
	const LOGS_USERS_DELETE = '%s deleted a user on %s';
	const LOGS_NEWS_CREATE = '%s created news on %s';
	const LOGS_NEWS_UPDATE = '%s updated news on %s';
	const LOGS_NEWS_DELETE = '%s deleted news on %s';
	const LOGS_GAMES_CREATE = '%s created a new game on %s';
	const LOGS_GAMES_UPDATE = '%s updated a game on %s';
	const LOGS_GAMES_DELETE = '%s deleted a game on %s';
	const LOGS_FAQS_CREATE = '%s created a new FAQs on %s';
	const LOGS_FAQS_UPDATE = '%s updated a FAQs on %s';
	const LOGS_FAQS_DELETE = '%s deleted a FAQs on %s';
	const LOGS_ADMIN_LOGIN = '%s logged in on %s';
	const LOGS_ADMIN_LOGOUT = '%s logged out on %s';

/* USER ACTIVITY */	
	const LOGS_USER_LOGIN = '%s logged in on %s';
	const LOGS_USER_LOGOUT = '%s logged out on %s';
	
/* USER ACTIONS */
	const LOGS_USER_LOGIN_ACTION = 'log in';
	const LOGS_USER_LOGOUT_ACTION = 'log out';
	const CATEGORY_GAME_COUNT = 6;
	const CATEGORY_GAME_PAGING = 3;
/* APPS STATUS*/
	const PUBLISH = '1';
	const DRAFT = '2';

	private $constant;


	public static function app_status() 
	{
		$_constants = array(
						self::PUBLISH => _('Published'),
						self::DRAFT => _('Draft'),
				);

		return $_constants;
	}

	public static function status($val) 
	{
		$text = '';
		switch($val) 
		{
			case 1: $text = 'PURCHASED';
					break;
			case 2: $text = 'ERROR ON PROCESS';
					break;
			case 3: $text = 'PROCESSING';
					break;
			case 4: $text = 'NOT ENOUGH CREDITS';
					break;
			case 5: $text = 'EXPIRED';
					break;
			default: break;
		}

		return $text;
	}

	public static function getCountries() 
	{
		$countries = ['Indonesia', 'Thailand', 'Malaysia', 'Singapore', 'Republic of the Philippines', 'Vietnam', 'Myanmar', 'Brunei', 'Cambodia', 'Laos'];
		sort($countries);
		
		return $countries;
	}

}
