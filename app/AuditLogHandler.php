<?php

class AuditLogHandler
{
    public function onLogin($user)
    {
       $_activity = sprintf(Constant::LOGS_ADMIN_LOGIN, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onLastLoginUser($user)
    {
       $_activity = sprintf(Constant::LOGS_ADMIN_LOGIN, $user->username, Carbon::now()->toDayDateTimeString());
       $log = User::updateLastLogin($user->id);
    }

    public function onLogout($user)
    {
       $_activity = sprintf(Constant::LOGS_ADMIN_LOGOUT, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onUserCreate($user)
    {
       $_activity = sprintf(Constant::LOGS_USER_CREATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onUserUpdate($user)
    {
       $_activity = sprintf(Constant::LOGS_USER_UPDATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onUserDelete($user)
    {
       $_activity = sprintf(Constant::LOGS_USER_DELETE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onNewsCreate($user)
    {
       $_activity = sprintf(Constant::LOGS_NEWS_CREATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onNewsUpdate($user)
    {
       $_activity = sprintf(Constant::LOGS_NEWS_UPDATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onNewsDelete($user)
    {
       $_activity = sprintf(Constant::LOGS_NEWS_DELETE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onGamesCreate($user)
    {
       $_activity = sprintf(Constant::LOGS_GAMES_CREATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onGamesUpdate($user)
    {
       $_activity = sprintf(Constant::LOGS_GAMES_UPDATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onGamesDelete($user)
    {
       $_activity = sprintf(Constant::LOGS_GAMES_DELETE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onFAQSCreate($user)
    {
       $_activity = sprintf(Constant::LOGS_FAQS_CREATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onFAQSUpdate($user)
    {
       $_activity = sprintf(Constant::LOGS_FAQS_UPDATE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function onFAQSDelete($user)
    {
       $_activity = sprintf(Constant::LOGS_FAQS_DELETE, $user->username, Carbon::now()->toDayDateTimeString());
       $log = AdminLog::createLogs($_activity);
    }

    public function subscribe($events)
    {
        $events->listen('audit.login', 'AuditLogHandler@onLogin');
        $events->listen('audit.logout', 'AuditLogHandler@onLogout');
        $events->listen('audit.users.create', 'AuditLogHandler@onUserCreate');
        $events->listen('audit.users.update', 'AuditLogHandler@onUserUpdate');
        $events->listen('audit.users.delete', 'AuditLogHandler@onUserDelete');
        $events->listen('audit.users.lastlogin', 'AuditLogHandler@onLastLoginUser');
        $events->listen('audit.news.create', 'AuditLogHandler@onNewsCreate');
        $events->listen('audit.news.update', 'AuditLogHandler@onNewsUpdate');
        $events->listen('audit.news.delete', 'AuditLogHandler@onNewsDelete');
        $events->listen('audit.games.create', 'AuditLogHandler@onGamesCreate');
        $events->listen('audit.games.update', 'AuditLogHandler@onGamesUpdate');
        $events->listen('audit.games.delete', 'AuditLogHandler@onGamesDelete');
        $events->listen('audit.faqs.create', 'AuditLogHandler@onFAQSCreate');
        $events->listen('audit.faqs.update', 'AuditLogHandler@onFAQSUpdate');
        $events->listen('audit.faqs.delete', 'AuditLogHandler@onFAQSDelete');

    }
}