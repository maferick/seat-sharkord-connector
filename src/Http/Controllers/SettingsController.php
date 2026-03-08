<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Seat\SharkordConnector\Models\SharkordConnectorSetting;

final class SettingsController extends Controller
{
    public function index()
    {
        return view('seat-sharkord-connector::settings', [
            'settings' => SharkordConnectorSetting::query()->first(),
        ]);
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'sharkord_base_url' => 'required|url',
            'sharkord_api_base_path' => 'required|string',
            'signing_secret_encrypted_or_protected' => 'required|string',
            'diagnostics_bearer_token_encrypted_or_protected' => 'nullable|string',
            'request_timeout_seconds' => 'required|integer|min:1|max:60',
        ]);

        SharkordConnectorSetting::query()->updateOrCreate(['id' => 1], $data + [
            'signing_mode' => 'hmac',
            'default_role_sync_mode' => 'authoritative',
            'main_character_strategy' => 'seat-primary-or-first',
            'auto_push_disable_restore' => true,
            'dry_run_mode' => false,
            'enabled' => true,
        ]);

        return redirect()->back()->with('status', 'Sharkord connector settings updated.');
    }
}
