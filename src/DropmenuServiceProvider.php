<?php

namespace Secrethash\Dropmenu;

use Illuminate\Support\ServiceProvider;

class DropmenuServiceProvider extends ServiceProvider
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
        $this->commands('command.dropmenu.migration');
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->make('Secrethash\Dropmenu\Dropmenu');
        
        $this->registerCommands();
        
        $this->bindFacade();

    }

    private function bindFacade() {
        $this->app->bind('dropmenu', function($app) {
            return new Dropmenu();
        });
    }


    /**
     * Register the artisan commands.
     *
     * @return void
     */
    private function registerCommands()
    {
        $this->app->singleton('command.dropmenu.migration', function ($app) {
            return new MigrationCommand();
        });
    }

    /**
     * Get the services provided.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'command.dropmenu.migration'
        ];
    }
}
