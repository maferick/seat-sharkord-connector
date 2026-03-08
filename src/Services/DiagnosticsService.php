<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

final class DiagnosticsService
{
    public function __construct(private readonly SharkordClient $client)
    {
    }

    public function health(): array
    {
        return $this->client->getDiagnostics('/providers/seat/health');
    }

    public function providers(): array
    {
        return $this->client->getDiagnostics('/providers');
    }
}
