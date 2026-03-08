<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Seat\SharkordConnector\Services\ManualSyncService;

final class UserFlowController extends Controller
{
    public function index(): View
    {
        return view('seat-sharkord-connector::user-flow', [
            'credential' => session('sharkord_one_time_credential'),
            'status' => session('status'),
        ]);
    }

    public function link(ManualSyncService $syncService): RedirectResponse
    {
        $result = $syncService->link();

        return redirect()->route('sharkord-connector.user-flow')->with([
            'status' => 'Sharkord account linked/synced.',
            'sharkord_one_time_credential' => $this->credentialPayload($result['response']),
        ]);
    }

    public function resync(ManualSyncService $syncService): RedirectResponse
    {
        $syncService->resync();

        return redirect()->route('sharkord-connector.user-flow')->with('status', 'Sharkord access re-synced.');
    }

    public function resetPassword(ManualSyncService $syncService): RedirectResponse
    {
        $result = $syncService->resetPassword();

        return redirect()->route('sharkord-connector.user-flow')->with([
            'status' => 'Sharkord password reset has been issued.',
            'sharkord_one_time_credential' => $this->credentialPayload($result['response']),
        ]);
    }

    private function credentialPayload(array $response): ?array
    {
        if (!isset($response['temporary_password']) && !isset($response['password_setup_url']) && !isset($response['password_setup_token'])) {
            return null;
        }

        return [
            'temporary_password' => $response['temporary_password'] ?? null,
            'must_change_password' => (bool) ($response['must_change_password'] ?? false),
            'password_setup_url' => $response['password_setup_url'] ?? null,
            'password_setup_token' => $response['password_setup_token'] ?? null,
        ];
    }
}
