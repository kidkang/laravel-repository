<?php

namespace Yjtec\Repo;

use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\ServiceProvider;

class RepoServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                Commands\MakeCommand::class,
                Commands\PublishCommand::class,
            ]);
        }
        $this->app->make(RepoManifest::class)->bind();

    }

    public function register()
    {
        $this->app->singleton(RepoManifest::class, function ($app) {
            return new RepoManifest(
                $app, new Filesystem, app_path('Repositories')
            );
        });
    }

}
