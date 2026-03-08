<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Seat\SharkordConnector\Models\SharkordSyncLog;
use Seat\SharkordConnector\Services\IdentityNormalizer;
use Seat\SharkordConnector\Services\SharkordClient;

final class SyncUserToSharkord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly array $seatUser)
    {
    }

    public function handle(IdentityNormalizer $normalizer, SharkordClient $client): void
    {
        $payload = $normalizer->normalize($this->seatUser)->toArray();
        $response = $client->upsertUser($payload);

        SharkordSyncLog::query()->create([
            'seat_user_id' => $payload['external_user_id'],
            'event_type' => 'upsert',
            'request_id' => $payload['event_id'],
            'status' => 'success',
            'payload_excerpt_json' => $payload,
            'response_excerpt_json' => $response,
        ]);
    }
}
