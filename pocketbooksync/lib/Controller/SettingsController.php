<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\Controller;

use OCA\PocketBookSync\Service\ConfigService;
use OCA\PocketBookSync\Service\SyncService;
use OCP\AppFramework\Controller;
use OCP\AppFramework\Http\DataResponse;
use OCP\AppFramework\Http\JSONResponse;
use OCP\IRequest;
use OCP\IUserSession;
use Throwable;

class SettingsController extends Controller {
	private string $userId;

	public function __construct(
		string $appName,
		IRequest $request,
		IUserSession $userSession,
		private ConfigService $configService,
		private SyncService $syncService,
	) {
		parent::__construct($appName, $request);
		$this->userId = $userSession->getUser()?->getUID() ?? '';
	}

	public function get(): DataResponse {
		return new DataResponse($this->configService->getSettings($this->userId));
	}

	/** @param array<string, mixed> $payload */
	public function save(array $payload): DataResponse {
		$this->configService->saveSettings($this->userId, $payload);
		return new DataResponse(['status' => 'saved']);
	}

	public function testConnection(): JSONResponse {
		try {
			$ok = $this->syncService->testConnection($this->userId);
			return new JSONResponse(['ok' => $ok]);
		} catch (Throwable $e) {
			return new JSONResponse(['ok' => false, 'error' => $e->getMessage()], 500);
		}
	}

	public function syncNow(): JSONResponse {
		try {
			$result = $this->syncService->syncUser($this->userId);
			return new JSONResponse(['ok' => true, 'result' => $result]);
		} catch (Throwable $e) {
			$this->configService->setLastSync($this->userId, 'Error: ' . $e->getMessage());
			return new JSONResponse(['ok' => false, 'error' => $e->getMessage()], 500);
		}
	}
}
