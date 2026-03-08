<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

use GuzzleHttp\Client;

final class SharkordClient
{
    public function __construct(
        private readonly RequestSigner $signer,
    ) {
    }

    public function authLogin(array $payload): array { return $this->sendSigned('/auth/login', $payload); }
    public function authLink(array $payload): array { return $this->sendSigned('/auth/link', $payload); }
    public function upsertUser(array $payload): array { return $this->sendSigned('/users/upsert', $payload); }
    public function disableUser(array $payload): array { return $this->sendSigned('/users/disable', $payload); }
    public function restoreUser(array $payload): array { return $this->sendSigned('/users/restore', $payload); }
    public function softDeleteUser(array $payload): array { return $this->sendSigned('/users/soft-delete', $payload); }
    public function syncRoles(array $payload): array { return $this->sendSigned('/roles/sync', $payload); }
    public function previewRoles(array $payload): array { return $this->sendSigned('/roles/preview', $payload); }
    public function previewEligibility(array $payload): array { return $this->sendSigned('/eligibility/preview', $payload); }
    public function provisionPassword(array $payload): array { return $this->sendSigned('/users/provision-password', $payload); }
    public function resetPassword(array $payload): array { return $this->sendSigned('/users/reset-password', $payload); }

    public function getDiagnostics(string $path): array
    {
        $settings = ProviderConfigValidator::settings();
        $client = new Client(['base_uri' => rtrim($settings['sharkord_base_url'], '/'), 'timeout' => $settings['request_timeout_seconds']]);
        $response = $client->get('/api/v1/ext' . $path, ['headers' => ['Authorization' => 'Bearer ' . $settings['diagnostics_bearer_token']]]);
        return json_decode((string) $response->getBody(), true) ?? [];
    }

    private function sendSigned(string $path, array $payload): array
    {
        $settings = ProviderConfigValidator::settings();
        $rawBody = json_encode($payload, JSON_THROW_ON_ERROR);
        $headers = $this->signer->makeHeaders('seat', $settings['signing_secret'], $rawBody, $payload['event_id'] ?? null);

        $client = new Client([
            'base_uri' => rtrim($settings['sharkord_base_url'], '/'),
            'timeout' => $settings['request_timeout_seconds'],
            'verify' => $settings['verify_tls'],
        ]);

        $response = $client->post(rtrim($settings['sharkord_api_base_path'], '/') . $path, [
            'headers' => $headers,
            'body' => $rawBody,
        ]);

        return json_decode((string) $response->getBody(), true) ?? [];
    }
}
