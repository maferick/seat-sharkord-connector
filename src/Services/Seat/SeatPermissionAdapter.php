<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services\Seat;

final class SeatPermissionAdapter
{
    public function forUser(object $user): array
    {
        if (!method_exists($user, 'getAllPermissions')) {
            return [];
        }

        return collect($user->getAllPermissions())
            ->map(fn ($permission) => (string) data_get($permission, 'name'))
            ->filter()
            ->unique()
            ->values()
            ->all();
    }
}
