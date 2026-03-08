<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Seat\SharkordConnector\Services\IdentityNormalizer;

final class LoginExportController extends Controller
{
    public function __invoke(Request $request, IdentityNormalizer $normalizer)
    {
        $payload = $normalizer->normalize($request->all())->toArray();

        return response()->json($payload);
    }
}
