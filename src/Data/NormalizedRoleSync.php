<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Data;

final class NormalizedRoleSync
{
    public function __construct(
        public readonly array $payload,
    ) {
    }

    public function toArray(): array
    {
        return $this->payload;
    }
}
