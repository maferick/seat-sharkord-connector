<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Seat\SharkordConnector\Data\EligibilityDecision;

final class EligibilityDecisionTest extends TestCase
{
    public function test_serializes_state_and_reasons(): void
    {
        $decision = new EligibilityDecision('ineligible', ['deny_group_match']);

        self::assertSame('ineligible', $decision->toArray()['eligibility_state']);
        self::assertSame(['deny_group_match'], $decision->toArray()['reason_codes']);
    }
}
