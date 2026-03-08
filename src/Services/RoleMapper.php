<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

use Seat\SharkordConnector\Models\SharkordRoleMapping;

final class RoleMapper
{
    public function map(array $seatGroups): array
    {
        $mappings = SharkordRoleMapping::query()->where('enabled', true)->get();

        return $mappings
            ->filter(fn ($mapping) => in_array($mapping->source_key, $seatGroups, true))
            ->map(fn ($mapping) => [
                'external_role_key' => $mapping->source_key,
                'sharkord_role_key' => $mapping->sharkord_role_key,
                'sync_mode' => $mapping->sync_mode,
            ])
            ->values()
            ->all();
    }
}
