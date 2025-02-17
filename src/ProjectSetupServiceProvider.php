<?php
namespace zhrnnsw\ProjectSetup;

use Illuminate\Support\ServiceProvider;
use zhrnnsw\ProjectSetup\Commands\SetupProject;

class ProjectSetupServiceProvider extends ServiceProvider
{
    public function register()
    {   
        // Register package services
        $this->mergeConfigFrom(__DIR__.'/../config/projectsetup.php', 'projectsetup');

        $this->commands([
            SetupProject::class,
        ]);
    }

    public function boot()
    {
        // Load routes, views, and commands
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'projectsetup');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__.'/../config/projectsetup.php' => config_path('projectsetup.php'),
                __DIR__.'/../database/migrations/' => database_path('migrations'),
                __DIR__.'/../resources/views' => resource_path('views/vendor/projectsetup'),
            ], 'projectsetup-assets');
            
            $this->commands([
                \zhrnnsw\ProjectSetup\Commands\SetupProject::class,
            ]);
        }
    }
}