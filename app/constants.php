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
	const LOGS_NEWS_DELETED = '%s deleted news on %s';
	const LOGS_GAMES_CREATE = '%s created a new game on %s';
	const LOGS_GAMES_UPDATE = '%s updated a game on %s';
	const LOGS_ADMIN_LOGIN = '%s logged in on %s';
	const LOGS_ADMIN_LOGOUT = '%s logged out on %s';

	public static $USER_ROLES = ['superadmin','admin','editor','member'];

}
