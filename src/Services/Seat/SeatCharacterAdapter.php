<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services\Seat;

use Illuminate\Support\Facades\DB;

final class SeatCharacterAdapter
{
    public function forUser(object $user): array
    {
        if (method_exists($user, 'characters')) {
            $items = $user->characters;
            if ($items) {
                return collect($items)->map(fn ($character) => $this->normalize($character))->values()->all();
            }
        }

        if (DB::getSchemaBuilder()->hasTable('character_user') && DB::getSchemaBuilder()->hasTable('character_infos')) {
            return DB::table('character_user')
                ->join('character_infos', 'character_infos.character_id', '=', 'character_user.character_id')
                ->where('character_user.user_id', data_get($user, 'id'))
                ->select([
                    'character_infos.character_id',
                    'character_infos.name as character_name',
                    'character_infos.corporation_id as corp_id',
                    'character_infos.alliance_id as alliance_id',
                    'character_user.main as is_main',
                ])
                ->get()
                ->map(fn ($character) => $this->normalize($character))
                ->values()
                ->all();
        }

        return [];
    }

    private function normalize(object|array $character): array
    {
        return [
            'character_id' => (int) data_get($character, 'character_id'),
            'character_name' => data_get($character, 'character_name') ?? data_get($character, 'name'),
            'corp_id' => data_get($character, 'corp_id') ?? data_get($character, 'corporation_id'),
            'alliance_id' => data_get($character, 'alliance_id'),
            'is_main' => (bool) (data_get($character, 'is_main') ?? data_get($character, 'main') ?? false),
        ];
    }
}
