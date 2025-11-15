<?php

namespace nplesa\Tracker;

use Illuminate\Support\ServiceProvider;
use nplesa\Tracker\Services\PhpCompatibilityScanner;

class Php85TrackerServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tracker.php', 'tracker');

        $this->app->singleton(PhpCompatibilityScanner::class, function () {
            return new PhpCompatibilityScanner();
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/tracker.php' => config_path('tracker.php'),
        ], 'tracker-config');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Nplesa\Tracker\Commands\ScanCompatibility::class,
            ]);
        }
    }
}
