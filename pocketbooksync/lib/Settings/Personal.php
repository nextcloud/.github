<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\Settings;

use OCP\AppFramework\Http\TemplateResponse;
use OCP\IL10N;
use OCP\Settings\ISettings;

class Personal implements ISettings {
	public function __construct(
		private IL10N $l10n,
	) {
	}

	public function getForm(): TemplateResponse {
		return new TemplateResponse('pocketbooksync', 'settings');
	}

	public function getSection(): string {
		return 'additional';
	}

	public function getPriority(): int {
		return 50;
	}
}
