<?php

namespace Akw82\LaravelLivewireModuleGenerator;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Akw82\LaravelLivewireModuleGenerator\Commands\{
    GenerateCommand,
    GenerateModel,
    GenerateMigration,
    GenerateObserver,
    GenerateView,
    GenerateRoute,
    GenerateNavigation,
};

class GenerateModuleServiceProvider extends ServiceProvider
{

    public function register()
    {
        $this->registerConfig();
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->commands([
                GenerateCommand::class,     // generate:module
                GenerateModel::class,       // generate:model
                GenerateMigration::class,   // generate:migration
                GenerateObserver::class,    // generate:observer
                GenerateView::class,        // generate:view
                GenerateRoute::class,       // generate:route
                GenerateNavigation::class   // generate:navigation
            ]);

            /**
             * creating a module_generator.php file in the /config directory.
             * php artisan vendor:publish --provider="Akw82\LaravelLivewireModuleGenerator\GenerateModuleServiceProvider" --tag="config"
             */
            $this->publishes([
                __DIR__ . '/../config/module_generator.php' => config_path('module_generator.php'),
            ], 'config');
        }
    }


    protected function registerConfig()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/module_generator.php', 'module_generator');
    }
}
