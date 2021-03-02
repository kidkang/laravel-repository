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
    public function boot(Filesystem $filesystem)
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepoIMakeCommand::class,
                RepoMakeCommand::class,
            ]);
        }

        $this->makeInterface($filesystem);

    }

    private function makeInterface($filesystem)
    {

        $path = app_path('Repositories/Contracts');

        if (is_dir($path)) {
            $files = scandir($path);
            foreach ($files as $file) {
                if (preg_match("/(.*?)Interface\.php/i", $file, $match)) {
                    $fileName = $match[1];
                    $this->app->bind(
                        'App\Repositories\Contracts\\' . $fileName . 'Interface',
                        'App\Repositories\Eloquent\\' . $fileName . 'Repository'
                    );
                }
            }
        }
    }
}
