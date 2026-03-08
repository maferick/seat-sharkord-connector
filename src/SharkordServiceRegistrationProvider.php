<?php

declare(strict_types=1);

namespace Seat\SharkordConnector;

use Illuminate\Support\ServiceProvider;
use Seat\SharkordConnector\Services\DiagnosticsService;
use Seat\SharkordConnector\Services\EligibilityResolver;
use Seat\SharkordConnector\Services\IdentityNormalizer;
use Seat\SharkordConnector\Services\MainCharacterResolver;
use Seat\SharkordConnector\Services\RequestSigner;
use Seat\SharkordConnector\Services\RoleMapper;
use Seat\SharkordConnector\Services\SharkordClient;

class SharkordServiceRegistrationProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(RequestSigner::class);
        $this->app->singleton(MainCharacterResolver::class);
        $this->app->singleton(RoleMapper::class);
        $this->app->singleton(EligibilityResolver::class);
        $this->app->singleton(IdentityNormalizer::class);
        $this->app->singleton(SharkordClient::class);
        $this->app->singleton(DiagnosticsService::class);
    }
}
