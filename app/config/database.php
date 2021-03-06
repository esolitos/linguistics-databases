<?php

return array(

	'fetch' => PDO::FETCH_CLASS,

	'default' => 'mysql',

	'connections' => array(

		'mysql' => array(
			'driver'    => 'mysql',
			'host'      => getenv('LARAVEL_DB_HOST'),
			'database'  => getenv('LARAVEL_DB_DBNAME'),
			'username'  => getenv('LARAVEL_DB_USER'),
			'password'  => getenv('LARAVEL_DB_PASSWORD'),
			'charset'   => getenv('LARAVEL_DB_CHARSET'),
			'collation' => getenv('LARAVEL_DB_COLLATION'),
			'prefix'    => '',
		),
	),

	'migrations' => 'migrations',
);
