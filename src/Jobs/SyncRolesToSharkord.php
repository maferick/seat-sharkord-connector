<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Seat\SharkordConnector\Services\IdentityNormalizer;
use Seat\SharkordConnector\Services\SharkordClient;

final class SyncRolesToSharkord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly array $seatUser)
    {
    }

    public function handle(IdentityNormalizer $normalizer, SharkordClient $client): void
    {
        $payload = $normalizer->normalize($this->seatUser)->toArray();

        $client->syncRoles([
            'provider' => $payload['provider'],
            'event_id' => $payload['event_id'],
            'issued_at' => $payload['issued_at'],
            'external_user_id' => $payload['external_user_id'],
            'sync_mode' => 'authoritative',
            'external_roles' => array_map(fn (string $group) => ['key' => $group, 'name' => ucfirst($group)], $payload['groups']),
            'mapped_roles' => array_map(fn (array $role) => [
                'external_role_key' => $role['external_role_key'],
                'sharkord_role_key' => $role['sharkord_role_key'],
            ], $payload['mapped_roles']),
        ]);
    }
}
