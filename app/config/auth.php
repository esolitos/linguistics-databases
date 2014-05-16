<?php

return array(

	'driver' => 'eloquent',
	'model' => 'User',
	'table' => 'user',
	'reminder' => array(

		'email' => 'emails.auth.reminder',
		'table' => 'token',
		'expire' => 60,
	),

);
