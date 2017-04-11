<?php

namespace Secrethash\Dropmenu;

use Illuminate\Support\ServiceProvider;

class MenuServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        // loading the routes
        // require __DIR__ . "/Http/routes.php";
        // $configPath = __DIR__ . '/config/trickster.php';
        // $this->publishes([$configPath => config_path('trickster.php')]);
        // $this->mergeConfigFrom($configPath, 'trickster');

        // Registers Commands
        $this->commands('command.secrethash.migration');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Secrethash\Dropmenu\Menu');

        $this->bindFacade();

    }

    private function bindFacade() {
        $this->app->bind('menu', function($app) {
            return new Dropmenu();
        });
    }

}
