<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Tests\Unit;

use PHPUnit\Framework\TestCase;
use Seat\SharkordConnector\Services\MainCharacterResolver;

final class MainCharacterResolverTest extends TestCase
{
    public function test_prefers_explicit_main_character(): void
    {
        $resolver = new MainCharacterResolver();

        $main = $resolver->resolve([
            ['character_id' => 22, 'is_main' => false],
            ['character_id' => 11, 'is_main' => true],
        ]);

        self::assertSame(11, $main['character_id']);
    }
}
