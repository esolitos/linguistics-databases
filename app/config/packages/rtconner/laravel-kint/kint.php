<?php

/*
|--------------------------------------------------------------------------
| Kint Configuration Options
|--------------------------------------------------------------------------
|
| See Kint documentation for full details on what each option does.
|
*/

return array(
	
	'enabled' => true, // if set to false, kint will become silent

	'displayCalledFrom' => true,
	
	'fileLinkFormat' => ini_get('xdebug.file_link_format'),
	
	'appRootDirs' => array( // abbreviate displayed paths
 		base_path()=>'ROOT'
	),
	
	'maxStrLength' => 160,
	
	'charEncodings' => array(),

	'maxLevels' => 10,

	'theme' => 'original',
	
);