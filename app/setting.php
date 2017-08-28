<?php

return [
	//setting display error
	'displayErrorDetails'	=> true,

	'addContentLengthHeader' => false,

	//setting timezone
	'timezone'	=> 'Asia/Jakarta',

	//setting language
	'lang'	=> [
		'default'	=> 'id',
	],

	//setting db (with doctrine)
	'db'	=> [
		'url'	=> 'mysql://root:mustaqim@localhost/match-making',
	],

	'determineRouteBeforeAppMiddleware' => true,

	'reporting' => [
       'base_uri' => 'http://localhost/Project-Mit/match-making/public/api/',
       'headers' => [
           'key' => @$_ENV['REPORTING_API_KEY'],
           'Accept' => 'application/json',
           'Content-Type' => 'application/json',
           'Authorization' => @$_SESSION['key']['key_token']
       ],
  ],
	// Setting View
	'view' => [
		'path'	=>	__DIR__ . '/../views',
		'twig'	=> 	[
			'cache'	=>	false,
		]
	],
];
