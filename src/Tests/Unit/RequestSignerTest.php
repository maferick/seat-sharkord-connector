<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Seat\SharkordConnector\Services\RequestSigner;

final class RequestSignerTest extends TestCase
{
    public function test_it_builds_required_headers(): void
    {
        $headers = (new RequestSigner())->makeHeaders('seat', 'secret', '{"ping":1}', 'evt_1');

        self::assertArrayHasKey('x-sharkord-provider', $headers);
        self::assertArrayHasKey('x-sharkord-signature', $headers);
    }
}
