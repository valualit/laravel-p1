<?php

return [

	'generate' => [
		'controller' => true,
		'resource' => false,
		'request' => false,
		'model' => true,
		'mail' => false,
		'notification' => false,
		'event' => false,
		'listener' => false,
		'observer' => false,
		'job' => false,
		'rule' => false,
		'view' => true,
		'translation' => true,
		'routes' => true,
		'migration' => true,
		'seeder' => true,
		'factory' => false,
		'config' => true,
		'helpers' => true,
	],
		
	'default' => [
	

		/*
		|--------------------------------------------------------------------------
		| Type Of Routing
		|--------------------------------------------------------------------------
		|
		| If you need / don't need different route files for web and api
		| you can change the array entries like you need them.
		|
		| Supported: "web", "api", "simple"
		|
		*/

		'routing' => [ 'web', 'api' ],

		/*
		|--------------------------------------------------------------------------
		| Module Structure
		|--------------------------------------------------------------------------
		|
		| In case your desired module structure differs
		| from the default structure defined here
		| feel free to change it the way you like it,
		|
		*/

		'structure' => [
			'controllers' => 'Http/Controllers',
			'resources' => 'Http/Resources',
			'requests' => 'Http/Requests',
			'models' => 'Models',
			'mails' => 'Mail',
			'notifications' => 'Notifications',
			'events' => 'Events',
			'listeners' => 'Listeners',
			'observers' => 'Observers',
			'jobs' => 'Jobs',
			'rules' => 'Rules',
			'views' => 'resources/views',
			'translations' => 'resources/lang',
			'routes' => 'routes',
			'migrations' => 'database/migrations',
			'seeds' => 'database/seeds',
			'factories' => 'database/factories',
			'helpers' => '',
		],
	],

];