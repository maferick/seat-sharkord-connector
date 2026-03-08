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
        SharkordConnectorSetting::query()->updateOrCreate(['id' => 1], $request->all());

        return redirect()->back()->with('status', 'Sharkord connector settings updated.');
    }
}
