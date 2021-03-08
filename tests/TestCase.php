<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-02 18:01:31
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-08 13:36:49
 */
namespace Yjtec\Repo\Test;

use Orchestra\Testbench\TestCase as Orchestra;
use Yjtec\Repo\RepoServiceProvider;

abstract class TestCase extends Orchestra
{
    public function setUp(): void
    {
        parent::setUp();
    }
    /**
     * @param \Illuminate\Foundation\Application $app
     *
     * @return array
     */
    protected function getPackageProviders($app)
    {
        return [
            RepoServiceProvider::class,
        ];
    }

    /**
     * Set up the environment.
     *
     * @param \Illuminate\Foundation\Application $app
     */
    protected function getEnvironmentSetUp($app)
    {
        $app['config']->set('database.default', 'sqlite');
        $app['config']->set('database.connections.sqlite', [
            'driver' => 'sqlite',
            'database' => ':memory:',
            'prefix' => '',
        ]);

        $migraiont = include_once __DIR__ . '/migration.php';
        (new \CreateDemosTable)->up();
    }

}
