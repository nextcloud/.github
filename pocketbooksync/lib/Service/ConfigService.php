<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\Service;

use OCA\PocketBookSync\AppInfo\Application;
use OCP\IConfig;

class ConfigService {
	public const KEY_BASE_URL = 'base_url';
	public const KEY_USERNAME = 'username';
	public const KEY_PASSWORD = 'password';
	public const KEY_TARGET_FOLDER = 'target_folder';
	public const KEY_SYNC_INTERVAL_MIN = 'sync_interval_min';
	public const KEY_LAST_SYNC = 'last_sync';
	public const KEY_LAST_STATUS = 'last_status';

	public function __construct(private IConfig $config) {
	}

	/** @return array<string, mixed> */
	public function getSettings(string $userId): array {
		return [
			'baseUrl' => $this->getUserValue($userId, self::KEY_BASE_URL, 'https://cloud.pocketbook.digital'),
			'username' => $this->getUserValue($userId, self::KEY_USERNAME, ''),
			'password' => $this->getUserValue($userId, self::KEY_PASSWORD, ''),
			'targetFolder' => $this->getUserValue($userId, self::KEY_TARGET_FOLDER, '/PocketBook Highlights'),
			'syncIntervalMin' => (int)$this->getUserValue($userId, self::KEY_SYNC_INTERVAL_MIN, '60'),
			'lastSync' => $this->getUserValue($userId, self::KEY_LAST_SYNC, ''),
			'lastStatus' => $this->getUserValue($userId, self::KEY_LAST_STATUS, 'Never synced'),
		];
	}

	/** @param array<string, mixed> $payload */
	public function saveSettings(string $userId, array $payload): void {
		$this->setUserValue($userId, self::KEY_BASE_URL, rtrim((string)($payload['baseUrl'] ?? ''), '/'));
		$this->setUserValue($userId, self::KEY_USERNAME, (string)($payload['username'] ?? ''));
		$this->setUserValue($userId, self::KEY_PASSWORD, (string)($payload['password'] ?? ''));
		$this->setUserValue($userId, self::KEY_TARGET_FOLDER, (string)($payload['targetFolder'] ?? '/PocketBook Highlights'));
		$this->setUserValue($userId, self::KEY_SYNC_INTERVAL_MIN, (string)max(5, (int)($payload['syncIntervalMin'] ?? 60)));
	}

	public function setLastSync(string $userId, string $status): void {
		$this->setUserValue($userId, self::KEY_LAST_SYNC, (string)time());
		$this->setUserValue($userId, self::KEY_LAST_STATUS, $status);
	}

	public function shouldSync(string $userId): bool {
		$settings = $this->getSettings($userId);
		$interval = max(5, (int)$settings['syncIntervalMin']);
		$lastSync = (int)$settings['lastSync'];
		if ($lastSync === 0) {
			return true;
		}

		return (time() - $lastSync) >= ($interval * 60);
	}

	private function getUserValue(string $userId, string $key, string $default): string {
		return $this->config->getUserValue($userId, Application::APP_ID, $key, $default);
	}

	private function setUserValue(string $userId, string $key, string $value): void {
		$this->config->setUserValue($userId, Application::APP_ID, $key, $value);
	}
}
