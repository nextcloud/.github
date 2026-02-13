<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\AppInfo;

use OCP\AppFramework\App;

class Application extends App {
	public const APP_ID = 'pocketbooksync';

	public function __construct() {
		parent::__construct(self::APP_ID);
	}
}
