<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use InvalidArgumentException;
use Monolog\Logger as Monolog;
use Monolog\Handler\StreamHandler;

class AuditLogServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton('auditlog', function () {
            $config = config('logging.channels.audit');
            return new Monolog('auditlog', [
                new StreamHandler(
                    $config['path'], $config['level'] ?? 'debug',
                    $config['bubble'] ?? true, $config['permission'] ?? null, $config['locking'] ?? false
                )
            ]);
        });
    }
}