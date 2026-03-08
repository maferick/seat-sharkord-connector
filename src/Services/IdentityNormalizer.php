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

        $payload = [
            'provider_type' => 'seat',
            'event_id' => $seatUser['event_id'] ?? uniqid('evt_', true),
            'issued_at' => (int) round(microtime(true) * 1000),
            'external_user_id' => (string) $seatUser['seat_user_id'],
            'external_account_id' => (string) ($seatUser['seat_account_id'] ?? $seatUser['seat_user_id']),
            'username' => (string) ($seatUser['username'] ?? ('seat-user-' . $seatUser['seat_user_id'])),
            'display_name' => (string) ($main['character_name'] ?? ($seatUser['display_name'] ?? $seatUser['username'] ?? 'SeAT User')),
            'character_id' => isset($main['character_id']) ? (string) $main['character_id'] : null,
            'main_character_id' => isset($main['character_id']) ? (string) $main['character_id'] : null,
            'character_name' => $main['character_name'] ?? null,
            'main_character_name' => $main['character_name'] ?? null,
            'managed_fields' => [
                'username' => 'locked',
                'display_name' => 'external',
                'role_assignments' => 'locked',
                'account_status' => 'external',
            ],
            'account_state' => 'active',
            'eligibility_state' => $eligibility->state,
            'external_roles' => $mappedRoles,
            'metadata' => [
                'seat_user_id' => (string) $seatUser['seat_user_id'],
                'seat_groups' => array_values($seatUser['groups'] ?? []),
                'seat_permissions' => array_values($seatUser['permissions'] ?? []),
                'corp_id' => $main['corp_id'] ?? null,
                'alliance_id' => $main['alliance_id'] ?? null,
            ],
        ];

        return new NormalizedIdentity(array_filter($payload, static fn ($value) => $value !== null));
    }
}
