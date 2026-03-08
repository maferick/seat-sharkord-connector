<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Data;

final class EligibilityDecision
{
    public function __construct(
        public readonly string $state,
        public readonly array $reasonCodes = [],
    ) {
    }

    public function toArray(): array
    {
        return [
            'eligibility_state' => $this->state,
            'reason_codes' => $this->reasonCodes,
        ];
    }
}
