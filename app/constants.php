<?php
namespace Constantine;
/*
	Constants, Globals
*/
class Constant {

	/*
		option table constants
	*/

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
/* APPS STATUS*/
	const PUBLISH = '1';
	const DRAFT = '2';

	private $constant;


	public static function app_status() 
	{
		$_constants = array(
						self::PUBLISH => _('Publish'),
						self::DRAFT => _('Draft'),
				);

		return $_constants;
	}

}
