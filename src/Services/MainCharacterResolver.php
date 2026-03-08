<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

final class MainCharacterResolver
{
    public function resolve(array $characters): ?array
    {
        usort($characters, fn (array $a, array $b) => ($a['character_id'] ?? 0) <=> ($b['character_id'] ?? 0));

        foreach ($characters as $character) {
            if (($character['is_main'] ?? false) === true) {
                return $character;
            }
        }

        return $characters[0] ?? null;
    }
}
