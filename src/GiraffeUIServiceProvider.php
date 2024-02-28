<?php

namespace JayAitch\GiraffeUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use JayAitch\GiraffeUI\Components\Button;
use JayAitch\GiraffeUI\Console\Commands\GiraffeUIInstallCommand;

class GiraffeUIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Load views from the 'resources/views' directory within the package.
        $this->loadViewsFrom(__DIR__ . '/resources/views', 'giraffeui');

        // Register the blade component aliases. 
        // Usage: <x-gui::{component} />
        Blade::component('gui::button', Button::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/giraffeui.php' => config_path('giraffeui.php'),
            ], 'giraffeui-config');

            $this->commands([
                GiraffeUIInstallCommand::class,
            ]);
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/giraffeui.php', 'giraffeui');

        // Register the service the package provides.
        $this->app->singleton('giraffeui', function ($app) {
            return new GiraffeUI;
        });
    }

    /**
     * Console-specific booting.
    **/
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__ . '/../config/giraffeui.php' => config_path('giraffeui.php'),
        ], 'giraffeui.config');

        $this->commands([
            GiraffeUIInstallCommand::class,
        ]);
    }
}
