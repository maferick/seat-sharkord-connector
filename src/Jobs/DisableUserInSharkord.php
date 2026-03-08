<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Seat\SharkordConnector\Services\SharkordClient;

final class DisableUserInSharkord implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(private readonly string $externalUserId, private readonly array $reasonCodes = [])
    {
    }

    public function handle(SharkordClient $client): void
    {
        $client->disableUser([
            'provider' => 'seat',
            'event_id' => uniqid('evt_', true),
            'issued_at' => gmdate('c'),
            'external_user_id' => $this->externalUserId,
            'action' => 'disable',
            'reason' => 'lost_eligibility',
            'reason_codes' => $this->reasonCodes,
            'effective_at' => gmdate('c'),
            'preserve_content' => true,
        ]);
    }
}
