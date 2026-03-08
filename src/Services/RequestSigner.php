<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

final class RequestSigner
{
    public function makeHeaders(string $provider, string $secret, string $rawBody, ?string $requestId = null): array
    {
        $timestamp = (string) round(microtime(true) * 1000);
        $nonce = bin2hex(random_bytes(16));
        $signature = hash_hmac('sha256', sprintf('%s.%s.%s.%s', $provider, $timestamp, $nonce, $rawBody), $secret);

        return array_filter([
            'x-sharkord-provider' => $provider,
            'x-sharkord-timestamp' => $timestamp,
            'x-sharkord-nonce' => $nonce,
            'x-sharkord-signature' => $signature,
            'x-sharkord-request-id' => $requestId,
            'content-type' => 'application/json',
        ]);
    }
}
