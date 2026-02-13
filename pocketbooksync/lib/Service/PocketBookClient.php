<?php

declare(strict_types=1);

namespace OCA\PocketBookSync\Service;

use OCP\Http\Client\IClientService;

class PocketBookClient {
	public function __construct(
		private IClientService $clientService,
	) {
	}

	/** @param array<string, mixed> $settings */
	public function testConnection(array $settings): bool {
		$token = $this->authenticate($settings);
		return $token !== '';
	}

	/**
	 * @param array<string, mixed> $settings
	 * @return array<int, array<string, mixed>>
	 */
	public function fetchBooksWithAnnotations(array $settings): array {
		$token = $this->authenticate($settings);
		$client = $this->clientService->newClient();
		$response = $client->get($settings['baseUrl'] . '/api/v1/library/books', [
			'headers' => [
				'Authorization' => 'Bearer ' . $token,
				'Accept' => 'application/json',
			],
			'query' => [
				'includeAnnotations' => 'true',
			],
			'timeout' => 30,
		]);

		$payload = json_decode($response->getBody(), true, flags: JSON_THROW_ON_ERROR);
		return $payload['books'] ?? [];
	}

	/** @param array<string, mixed> $settings */
	private function authenticate(array $settings): string {
		$client = $this->clientService->newClient();
		$response = $client->post($settings['baseUrl'] . '/api/v1/auth/login', [
			'headers' => [
				'Accept' => 'application/json',
			],
			'json' => [
				'email' => $settings['username'],
				'password' => $settings['password'],
			],
			'timeout' => 30,
		]);

		$payload = json_decode($response->getBody(), true, flags: JSON_THROW_ON_ERROR);
		return (string)($payload['token'] ?? '');
	}
}
