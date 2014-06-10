<?php 

/*
 * This is an example how the configuration file should look.
 */

return [
  'LARAVEL_DEBUG'       => TRUE/FALSE,
  'LARAVEL_APP_EMAIL'		=> 'mail@example.xom',
  'LARAVEL_APP_SENDER'	=> 'Name Surname',
  'LARAVEL_APP_URL'			=> 'http://example.xom/',
  'LARAVEL_APP_KEY'			=> 'key',
	
	
  'LARAVEL_DB_HOST'				=> 'localhost',
  'LARAVEL_DB_DBNAME'			=> 'db_name',
  'LARAVEL_DB_USER'				=> 'username',
  'LARAVEL_DB_PASSWORD'		=> 'password',
  'LARAVEL_DB_CHARSET'    => 'utf8',
  'LARAVEL_DB_COLLATION'  => 'utf8_general_ci',
	
  'LARAVEL_REDIS_HOST'	=> 'localhost',
  'LARAVEL_REDIS_PORT'	=> 6379,
  'LARAVEL_REDIS_DB'		=> 0,
	
	
  'LARAVEL_MAIL_DRIVER'			=> 'sendmail',
	
  'LARAVEL_MAIL_SMTP_HOST'		=> '',
  'LARAVEL_MAIL_SMTP_PORT'		=> 0,
  'LARAVEL_MAIL_SMTP_USER'		=> '',
  'LARAVEL_MAIL_SMTP_PASS'		=> '',
  'LARAVEL_MAIL_SMTP_ENCRYPT'	=> 'tls',
	
  'LARAVEL_MAIL_SENDMAIL'		=> '/usr/sbin/sendmail -bs',
  'LARAVEL_MAIL_PRETEND'		=> TRUE/FALSE,
	
];