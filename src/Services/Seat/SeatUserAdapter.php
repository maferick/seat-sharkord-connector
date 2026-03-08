<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services\Seat;

use Illuminate\Support\Facades\Auth;

final class SeatUserAdapter
{
    public function currentUser(): array
    {
        $user = Auth::user();

        if (!$user) {
            throw new \RuntimeException('No authenticated SeAT user found.');
        }

        $id = (string) data_get($user, 'id', '');
        if ($id === '') {
            throw new \RuntimeException('Authenticated SeAT user is missing an id.');
        }

        $username = (string) (data_get($user, 'name') ?? data_get($user, 'username') ?? data_get($user, 'identity') ?? ('seat-user-' . $id));

        return [
            'seat_user_id' => $id,
            'seat_account_id' => (string) (data_get($user, 'account_id') ?? $id),
            'username' => $username,
            'display_name' => data_get($user, 'name') ?? data_get($user, 'username'),
            'email' => data_get($user, 'email'),
            'avatar_url' => data_get($user, 'avatar'),
            'user' => $user,
        ];
    }
}
