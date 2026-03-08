<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Services;

use Seat\SharkordConnector\Models\SharkordConnectorSetting;

final class ProviderConfigValidator
{
    public static function settings(): array
    {
        $settings = SharkordConnectorSetting::query()->firstOrFail();

        return [
            'sharkord_base_url' => $settings->sharkord_base_url,
            'sharkord_api_base_path' => $settings->sharkord_api_base_path ?: '/api/v1/ext',
            'request_timeout_seconds' => $settings->request_timeout_seconds ?: 10,
            'signing_secret' => $settings->signing_secret_encrypted_or_protected,
            'diagnostics_bearer_token' => $settings->diagnostics_bearer_token_encrypted_or_protected,
            'verify_tls' => true,
        ];
    }
}
