<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Http\Controllers;

use Illuminate\Routing\Controller;
use Seat\SharkordConnector\Services\DiagnosticsService;

final class DiagnosticsController extends Controller
{
    public function __invoke(DiagnosticsService $diagnosticsService)
    {
        return view('seat-sharkord-connector::diagnostics', [
            'providers' => $diagnosticsService->providers(),
            'health' => $diagnosticsService->health(),
        ]);
    }
}
