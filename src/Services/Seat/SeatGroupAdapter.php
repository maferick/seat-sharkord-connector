<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services\Seat;

use Illuminate\Support\Facades\DB;

final class SeatGroupAdapter
{
    public function forUser(object $user): array
    {
        if (method_exists($user, 'groups')) {
            $items = $user->groups;
            if ($items) {
                return collect($items)
                    ->map(fn ($group) => (string) (data_get($group, 'name') ?? data_get($group, 'group') ?? data_get($group, 'slug')))
                    ->filter()
                    ->unique()
                    ->values()
                    ->all();
            }
        }

        if (DB::getSchemaBuilder()->hasTable('group_user') && DB::getSchemaBuilder()->hasTable('groups')) {
            return DB::table('group_user')
                ->join('groups', 'groups.id', '=', 'group_user.group_id')
                ->where('group_user.user_id', data_get($user, 'id'))
                ->pluck('groups.name')
                ->filter()
                ->unique()
                ->values()
                ->all();
        }

        return [];
    }
}
