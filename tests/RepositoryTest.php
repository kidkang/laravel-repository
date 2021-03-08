<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-02 18:04:27
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-08 13:47:45
 */
namespace Yjtec\Repo\Test;

use Yjtec\Repo\Repository;

class RepositoryTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();
    }
    public function testDBevent()
    {
        $repo = $this->getRepo();
        $repo->start();
        $repo->commit();
        $repo->rollback();
        $this->assertTrue(true);
    }

    public function testTransaction()
    {
        $repo = $this->getRepo();
        $repo->transaction(function () {
            Model::create([
                'name' => 'foo',
            ]);
        });
        $a = Model::where('name', 'foo')->first();
        $this->assertEquals('foo', $a->name);
    }

    public function testTransactionWithException()
    {
        $repo = $this->getRepo();
        $this->expectException(\Exception::class);
        $repo->transaction(function () use ($repo) {
            Model::create([
                'name' => 'bar',
            ]);
            $repo->throw();
        });
    }

    protected function getRepo()
    {
        return new RepositoryDemo($this->app);
    }
}

class RepositoryDemo extends Repository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        // TODO: Implement model() method.
        return Model::class;
    }

    function throw () {
        throw new \Exception('error');
    }
}
