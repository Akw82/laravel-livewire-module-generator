<?php

namespace Akw82\LaravelLivewireModuleGenerator\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\ServiceProvider;
use Akw82\ModuleGenerator\Commands\GenerateCommand;
use Akw82\ModuleGenerator\Commands\GenerateModel;
use Akw82\ModuleGenerator\Commands\GenerateMigration;
use Akw82\ModuleGenerator\Commands\GenerateObserver;
use Akw82\ModuleGenerator\Commands\GenerateView;
use Akw82\ModuleGenerator\Commands\GenerateRoute;

class GenerateModuleServiceProvider extends ServiceProvider
{

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {

        if ($this->app->runningInConsole()) {

            $this->commands([
                GenerateCommand::class,
                GenerateModel::class,
                GenerateMigration::class,
                GenerateObserver::class,
                GenerateView::class,
                GenerateRoute::class,
            ]);
        }
    }
}
