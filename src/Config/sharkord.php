<?php

return [
    'provider' => 'seat',
    'signing_mode' => 'hmac',
    'api_base_path' => '/api/v1/ext',
    'request_timeout_seconds' => 10,
    'default_role_sync_mode' => 'authoritative',
    'main_character_strategy' => 'seat-primary-or-first',
    'username_policy_mode' => 'provider-managed-and-locked',
    'display_name_managed_policy' => 'external',
    'allow_manual_test_sync' => true,
    'auto_push_disable_restore' => true,
    'dry_run_mode' => false,
];
