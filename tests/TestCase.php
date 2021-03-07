<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-02 18:01:31
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-07 10:00:03
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

    }

}
