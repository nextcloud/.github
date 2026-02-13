<?php

declare(strict_types=1);

return [
	'routes' => [
		[
			'name' => 'Settings#get',
			'url' => '/settings',
			'verb' => 'GET',
		],
		[
			'name' => 'Settings#save',
			'url' => '/settings',
			'verb' => 'POST',
		],
		[
			'name' => 'Settings#testConnection',
			'url' => '/settings/test-connection',
			'verb' => 'POST',
		],
		[
			'name' => 'Settings#syncNow',
			'url' => '/settings/sync-now',
			'verb' => 'POST',
		],
	],
];
