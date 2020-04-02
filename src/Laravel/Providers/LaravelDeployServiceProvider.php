<?php

namespace stekel\LaravelDeploy\Providers;

use Illuminate\Support\ServiceProvider;
use stekel\LaravelDeploy\Laravel\Console\LaravelDeploy as LaravelDeployCommand;

class LaravelDeployServiceProvider extends ServiceProvider
{
    /**
     * Indicates if loading of the provider is deferred.
     *
     * @var bool
     */
    protected $defer = true;

    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->publishes([
            __DIR__.'/../Config/deploy.php' => config_path('deploy.php'),
        ]);

        if ($this->app->runningInConsole()) {

            $this->commands([
                LaravelDeployCommand::class,
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__.'/../Config/deploy.php', 'deploy'
        );

        $this->app->singleton('deploy', function($app) {

            return new DeployManager(config('deploy.sites'));
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [
            'deploy'
        ];
    }
}
