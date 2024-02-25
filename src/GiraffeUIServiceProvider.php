<?php

namespace JayAitch\GiraffeUI;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;
use JayAitch\GiraffeUI\Components\Button;

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
        $this->loadViewsFrom(__DIR__.'/resources/views', 'giraffeui');

        // Register the blade component aliases. 
        // Usage: <x-gui::{component} />
        Blade::component('gui::button', Button::class);
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        // Register your package's services
    }
}
