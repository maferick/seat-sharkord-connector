<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

use Seat\SharkordConnector\Data\NormalizedIdentity;

final class IdentityNormalizer
{
    public function __construct(
        private readonly MainCharacterResolver $mainCharacterResolver,
        private readonly RoleMapper $roleMapper,
        private readonly EligibilityResolver $eligibilityResolver,
    ) {
    }

    public function normalize(array $seatUser): NormalizedIdentity
    {
        $main = $this->mainCharacterResolver->resolve($seatUser['characters'] ?? []);
        $eligibility = $this->eligibilityResolver->evaluate([
            'groups' => $seatUser['groups'] ?? [],
            'corp_id' => $main['corp_id'] ?? null,
            'alliance_id' => $main['alliance_id'] ?? null,
        ]);
        $mappedRoles = $this->roleMapper->map($seatUser['groups'] ?? []);

        return new NormalizedIdentity([
            'provider' => 'seat',
            'event_id' => $seatUser['event_id'] ?? uniqid('evt_', true),
            'issued_at' => gmdate('c'),
            'external_user_id' => (string) $seatUser['seat_user_id'],
            'external_account_id' => (string) ($seatUser['seat_account_id'] ?? $seatUser['seat_user_id']),
            'identity' => [
                'character_id' => $main['character_id'] ?? null,
                'main_character_id' => $main['character_id'] ?? null,
                'character_name' => $main['character_name'] ?? null,
                'main_character_name' => $main['character_name'] ?? null,
            ],
            'profile' => [
                'username' => $seatUser['username'] ?? null,
                'display_name' => $main['character_name'] ?? ($seatUser['username'] ?? null),
                'email' => $seatUser['email'] ?? null,
                'avatar_url' => $seatUser['avatar_url'] ?? null,
            ],
            'managed_fields' => [
                'username' => 'locked',
                'display_name' => 'external',
                'roles' => 'locked',
                'account_status' => 'external',
            ],
            'account_state' => 'active',
            'eligibility_state' => $eligibility->state,
            'groups' => array_values($seatUser['groups'] ?? []),
            'mapped_roles' => $mappedRoles,
            'metadata' => [
                'seat_user_id' => (string) $seatUser['seat_user_id'],
                'seat_groups' => array_values($seatUser['groups'] ?? []),
                'corp_id' => $main['corp_id'] ?? null,
                'alliance_id' => $main['alliance_id'] ?? null,
            ],
        ]);
    }
}
