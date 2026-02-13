<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\BackgroundJob;

use OCA\PocketBookSync\Service\ConfigService;
use OCA\PocketBookSync\Service\SyncService;
use OCP\BackgroundJob\TimedJob;
use OCP\IUserManager;
use Psr\Log\LoggerInterface;
use Throwable;

class SyncJob extends TimedJob {
	public function __construct(
		private IUserManager $userManager,
		private ConfigService $configService,
		private SyncService $syncService,
		private LoggerInterface $logger,
	) {
		parent::__construct();
		$this->setInterval(300);
	}

	protected function run($argument): void {
		foreach ($this->userManager->search('') as $user) {
			$userId = $user->getUID();
			$settings = $this->configService->getSettings($userId);
			if ($settings['username'] === '' || $settings['password'] === '') {
				continue;
			}

			if (!$this->configService->shouldSync($userId)) {
				continue;
			}

			try {
				$this->syncService->syncUser($userId);
			} catch (Throwable $e) {
				$this->configService->setLastSync($userId, 'Error: ' . $e->getMessage());
				$this->logger->error('PocketBook background sync failed', [
					'exception' => $e,
					'userId' => $userId,
				]);
			}
		}
	}
}
