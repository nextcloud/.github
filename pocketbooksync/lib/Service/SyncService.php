<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\Service;

use OCP\Files\IRootFolder;
use OCP\Files\NotFoundException;

class SyncService {
	public function __construct(
		private ConfigService $configService,
		private PocketBookClient $client,
		private IRootFolder $rootFolder,
	) {
	}

	public function testConnection(string $userId): bool {
		$settings = $this->configService->getSettings($userId);
		return $this->client->testConnection($settings);
	}

	/** @return array{books:int, files:int} */
	public function syncUser(string $userId): array {
		$settings = $this->configService->getSettings($userId);
		$books = $this->client->fetchBooksWithAnnotations($settings);
		$userFolder = $this->rootFolder->getUserFolder($userId);
		$targetFolderPath = trim((string)$settings['targetFolder']);
		if ($targetFolderPath === '') {
			$targetFolderPath = '/PocketBook Highlights';
		}

		try {
			$targetFolder = $userFolder->get($targetFolderPath);
		} catch (NotFoundException) {
			$targetFolder = $userFolder->newFolder($targetFolderPath);
		}

		$written = 0;
		foreach ($books as $book) {
			$title = trim((string)($book['title'] ?? 'Unknown Title'));
			$author = trim((string)($book['author'] ?? 'Unknown Author'));
			$annotations = $book['annotations'] ?? [];
			$filename = $this->toSafeFilename($title . ' - ' . $author) . '.md';
			$contents = $this->renderBookMarkdown($title, $author, $annotations);

			if ($targetFolder->nodeExists($filename)) {
				$file = $targetFolder->get($filename);
				$file->putContent($contents);
			} else {
				$targetFolder->newFile($filename, $contents);
			}
			$written++;
		}

		$this->configService->setLastSync($userId, sprintf('OK: synced %d books', $written));
		return ['books' => count($books), 'files' => $written];
	}

	/** @param array<int, array<string, mixed>> $annotations */
	private function renderBookMarkdown(string $title, string $author, array $annotations): string {
		$lines = [
			'# ' . $title,
			'',
			'- Author: ' . $author,
			'- Synced at: ' . gmdate(DATE_ATOM),
			'',
			'## Highlights & Notes',
			'',
		];

		foreach ($annotations as $annotation) {
			$type = (string)($annotation['type'] ?? 'highlight');
			$text = trim((string)($annotation['text'] ?? ''));
			$note = trim((string)($annotation['note'] ?? ''));
			$location = (string)($annotation['location'] ?? '');
			if ($text === '' && $note === '') {
				continue;
			}

			$lines[] = '### ' . ucfirst($type) . ($location !== '' ? ' @ ' . $location : '');
			if ($text !== '') {
				$lines[] = '> ' . str_replace("\n", "\n> ", $text);
			}
			if ($note !== '') {
				$lines[] = '';
				$lines[] = '- Note: ' . $note;
			}
			$lines[] = '';
		}

		return implode("\n", $lines) . "\n";
	}

	private function toSafeFilename(string $name): string {
		$name = preg_replace('/[\\\\\/:*?"<>|]+/', '_', $name) ?? $name;
		$name = preg_replace('/\s+/', ' ', $name) ?? $name;
		return trim($name);
	}
}
