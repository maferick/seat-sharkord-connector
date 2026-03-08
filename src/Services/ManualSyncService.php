<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

use Seat\SharkordConnector\Models\SharkordSyncLog;
use Seat\SharkordConnector\Services\Seat\SeatUserContextResolver;

final class ManualSyncService
{
    public function __construct(
        private readonly SeatUserContextResolver $seatUserContextResolver,
        private readonly IdentityNormalizer $identityNormalizer,
        private readonly SharkordClient $client,
    ) {
    }

    public function link(): array
    {
        $context = $this->seatUserContextResolver->resolveCurrentUserContext();
        $payload = $this->identityNormalizer->normalize($context)->toArray();
        $response = $this->client->upsertUser($payload);

        if (($response['outcome'] ?? null) === 'applied') {
            $response = array_merge($response, $this->client->provisionPassword([
                'provider_type' => 'seat',
                'event_id' => $payload['event_id'],
                'external_user_id' => $payload['external_user_id'],
            ]));
        }

        $this->log('manual_link', $context, $payload, $response);

        return ['context' => $context, 'payload' => $payload, 'response' => $response];
    }

    public function resync(): array
    {
        $context = $this->seatUserContextResolver->resolveCurrentUserContext();
        $payload = $this->identityNormalizer->normalize($context)->toArray();
        $response = $this->client->syncRoles([
            'provider_type' => 'seat',
            'event_id' => $payload['event_id'],
            'external_user_id' => $payload['external_user_id'],
            'sync_mode' => 'authoritative',
            'roles' => $payload['external_roles'] ?? [],
        ]);

        $this->log('manual_resync', $context, $payload, $response);

        return ['context' => $context, 'payload' => $payload, 'response' => $response];
    }

    public function resetPassword(): array
    {
        $context = $this->seatUserContextResolver->resolveCurrentUserContext();
        $payload = $this->identityNormalizer->normalize($context)->toArray();
        $response = $this->client->resetPassword([
            'provider_type' => 'seat',
            'event_id' => $payload['event_id'],
            'external_user_id' => $payload['external_user_id'],
        ]);

        $this->log('manual_password_reset', $context, $payload, $response);

        return ['context' => $context, 'payload' => $payload, 'response' => $response];
    }

    private function log(string $eventType, array $context, array $payload, array $response): void
    {
        SharkordSyncLog::query()->create([
            'seat_user_id' => (string) $context['seat_user_id'],
            'seat_character_id' => data_get($payload, 'main_character_id'),
            'sharkord_external_user_id' => data_get($payload, 'external_user_id'),
            'event_type' => $eventType,
            'request_id' => data_get($payload, 'event_id'),
            'status' => (bool) data_get($response, 'success', false) ? 'success' : 'error',
            'http_status' => 200,
            'payload_excerpt_json' => [
                'provider_type' => data_get($payload, 'provider_type'),
                'external_user_id' => data_get($payload, 'external_user_id'),
                'external_roles_count' => count(data_get($payload, 'external_roles', [])),
            ],
            'response_excerpt_json' => [
                'success' => data_get($response, 'success', false),
                'outcome' => data_get($response, 'outcome'),
                'must_change_password' => data_get($response, 'must_change_password'),
                'has_temporary_password' => data_get($response, 'temporary_password') !== null,
                'password_setup_url' => data_get($response, 'password_setup_url'),
            ],
        ]);
    }
}
