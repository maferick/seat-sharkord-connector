<?php

declare(strict_types=1);

namespace Seat\SharkordConnector\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Artisan;
use Seat\SharkordConnector\Models\SharkordConnectorSetting;

class InstallSharkordConnectorCommand extends Command
{
    protected $signature = 'sharkord:install {--force : Run migrations in production without confirmation}';

    protected $description = 'Install Sharkord connector database tables and bootstrap default settings';

    public function handle(): int
    {
        $this->info('Installing Sharkord Connector...');

        $migrateResult = Artisan::call('migrate', [
            '--path' => 'vendor/sharkord/seat-sharkord-connector/src/database/migrations',
            '--force' => (bool) $this->option('force'),
        ]);

        $this->output->write(Artisan::output());

        if ($migrateResult !== 0) {
            $this->error('Migration step failed.');

            return self::FAILURE;
        }

        SharkordConnectorSetting::query()->firstOrCreate([
            'id' => 1,
        ], [
            'sharkord_base_url' => '',
            'sharkord_api_base_path' => (string) config('sharkord_connector.api_base_path', '/api/v1/ext'),
            'signing_mode' => (string) config('sharkord_connector.signing_mode', 'hmac'),
            'signing_secret_encrypted_or_protected' => '',
            'diagnostics_bearer_token_encrypted_or_protected' => null,
            'request_timeout_seconds' => (int) config('sharkord_connector.request_timeout_seconds', 10),
            'default_role_sync_mode' => (string) config('sharkord_connector.default_role_sync_mode', 'authoritative'),
            'main_character_strategy' => (string) config('sharkord_connector.main_character_strategy', 'seat-primary-or-first'),
            'auto_push_disable_restore' => (bool) config('sharkord_connector.auto_push_disable_restore', true),
            'dry_run_mode' => (bool) config('sharkord_connector.dry_run_mode', false),
            'enabled' => true,
        ]);

        $this->info('Sharkord Connector installed. Next step: open SeAT admin settings and provide Sharkord URL and secrets.');

        return self::SUCCESS;
    }
}
