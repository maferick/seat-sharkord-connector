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
                'key' => $mapping->sharkord_role_key,
                'name' => $mapping->source_label,
            ])
            ->unique('key')
            ->values()
            ->all();
    }
}
