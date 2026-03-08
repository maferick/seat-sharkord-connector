<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services\Seat;

final class SeatUserContextResolver
{
    public function __construct(
        private readonly SeatUserAdapter $userAdapter,
        private readonly SeatCharacterAdapter $characterAdapter,
        private readonly SeatGroupAdapter $groupAdapter,
        private readonly SeatPermissionAdapter $permissionAdapter,
    ) {
    }

    public function resolveCurrentUserContext(): array
    {
        $user = $this->userAdapter->currentUser();

        return [
            ...$user,
            'characters' => $this->characterAdapter->forUser($user['user']),
            'groups' => $this->groupAdapter->forUser($user['user']),
            'permissions' => $this->permissionAdapter->forUser($user['user']),
        ];
    }
}
