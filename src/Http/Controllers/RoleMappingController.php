<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\View\View;
use Seat\SharkordConnector\Models\SharkordRoleMapping;

final class RoleMappingController extends Controller
{
    public function index(): View
    {
        return view('seat-sharkord-connector::mapping', [
            'mappings' => SharkordRoleMapping::query()->orderBy('source_type')->orderBy('source_key')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'source_type' => 'required|string|max:80',
            'source_key' => 'required|string|max:255',
            'source_label' => 'required|string|max:255',
            'sharkord_role_key' => 'required|string|max:255',
            'sync_mode' => 'required|in:additive,authoritative',
            'enabled' => 'sometimes|boolean',
        ]);

        SharkordRoleMapping::query()->updateOrCreate(
            ['source_type' => $data['source_type'], 'source_key' => $data['source_key']],
            [...$data, 'enabled' => (bool) ($data['enabled'] ?? true)]
        );

        return back()->with('status', 'Role mapping saved.');
    }

    public function destroy(SharkordRoleMapping $mapping): RedirectResponse
    {
        $mapping->delete();

        return back()->with('status', 'Role mapping removed.');
    }
}
