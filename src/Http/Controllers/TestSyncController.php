<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Seat\SharkordConnector\Services\IdentityNormalizer;
use Seat\SharkordConnector\Services\SharkordClient;

final class TestSyncController extends Controller
{
    public function preview(Request $request, IdentityNormalizer $normalizer)
    {
        return response()->json($normalizer->normalize($request->all())->toArray());
    }

    public function upsert(Request $request, IdentityNormalizer $normalizer, SharkordClient $client)
    {
        $payload = $normalizer->normalize($request->all())->toArray();

        return response()->json($client->upsertUser($payload));
    }
}
