<?php

namespace JayAitch\GiraffeUI;

use Illuminate\Support\ServiceProvider;

class GiraffeUIServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any package services.
     *
     * @return void
     */
    public function boot()
    {
        // Load your package routes, views, assets, etc.

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'giraffeui');
        
        // $this->publishes([
        //     __DIR__.'/path/to/assets' => public_path('jayaitch/giraffeui'),
        // ], 'public');

        // Register your button component view
        // $this->loadViewComponentsAs('giraffeui', [
        //     \JayAitch\GiraffeUI\Components\Button::class => 'giraffeui::button',
        // ]);

        \Illuminate\Support\Facades\Blade::component('giraffeui::button', \JayAitch\GiraffeUI\Components\Button::class);

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
