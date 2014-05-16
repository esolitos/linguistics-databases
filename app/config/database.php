<?php

return array(

	'fetch' => PDO::FETCH_CLASS,

	'default' => 'mysql',

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => $_ENV['LARAVEL_DB_HOST'],
			'database'  => $_ENV['LARAVEL_DB_DBNAME'],
			'username'  => $_ENV['LARAVEL_DB_USER'],
			'password'  => $_ENV['LARAVEL_DB_PASSWORD'],
			'charset'   => $_ENV['LARAVEL_DB_CHARSET'],
			'collation' => $_ENV['LARAVEL_DB_COLLATION'],
			'prefix'    => '',
		),
	),

	'migrations' => 'migrations',

	'redis' => array(

		'cluster' => false,

		'default' => array(
			'host'     => $_ENV['LARAVEL_REDIS_HOST'],
			'port'     => $_ENV['LARAVEL_REDIS_PORT'],
			'database' => $_ENV['LARAVEL_REDIS_DB']
		),

	),

);
