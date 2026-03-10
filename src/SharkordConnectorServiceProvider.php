<?php

declare(strict_types=1);

namespace Seat\SharkordConnector;

use Seat\Services\AbstractSeatPlugin;
use Seat\SharkordConnector\Console\Commands\InstallSharkordConnectorCommand;

class SharkordConnectorServiceProvider extends AbstractSeatPlugin
{
    public function boot(): void
    {
        $this->registerConfig(__DIR__ . '/Config/sharkord.php', 'sharkord_connector');
        $this->registerRoutes(__DIR__ . '/routes/web.php', __DIR__ . '/routes/api.php');
        $this->registerViews(__DIR__ . '/resources/views', 'seat-sharkord-connector');
        $this->loadMigrationsFrom(__DIR__ . '/database/migrations');

        if ($this->app->runningInConsole()) {
            $this->commands([
                InstallSharkordConnectorCommand::class,
            ]);
        }
    }

    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/Config/sharkord.php', 'sharkord_connector');
        $this->app->register(SharkordServiceRegistrationProvider::class);
    }

    public function getName(): string
    {
        return 'Sharkord Connector';
    }

    public function getPackageRepositoryUrl(): string
    {
        return 'https://github.com/sharkord/sharkord';
    }

    public function getPackagistPackageName(): string
    {
        return 'sharkord/seat-sharkord-connector';
    }

    public function getPackagistVendorName(): string
    {
        return 'sharkord';
    }

    public function getPermissions(): array
    {
        return [
            'sharkord-connector.view' => [
                'label' => 'View Sharkord connector settings and diagnostics',
                'description' => 'Allows read-only access to Sharkord connector pages.',
            ],
            'sharkord-connector.manage' => [
                'label' => 'Manage Sharkord connector settings',
                'description' => 'Allows editing Sharkord connector settings and mappings.',
            ],
            'sharkord-connector.sync' => [
                'label' => 'Execute Sharkord sync actions',
                'description' => 'Allows manual preview/sync/disable actions to Sharkord.',
            ],
        ];
    }
}
