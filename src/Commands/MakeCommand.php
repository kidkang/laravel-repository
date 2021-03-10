<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-06 17:10:10
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-10 11:36:39
 */

namespace Yjtec\Repo\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputOption;

class MakeCommand extends GeneratorCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:rep';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new repository class';

    /**
     * The type of class being generated.
     *
     * @var string
     */
    protected $type = 'Repository';

    public function handle()
    {

        $name = $this->getNameInput('name');
        if ($this->option("mf")) {
            $this->call('make:model', ['name' => $name, '-f' => true]);
            if ($this->option('t')) {
                $this->makeTest($name, '--model');
            }
        }

        if ($this->option('m')) {
            $this->call('make:model', ['name' => $name]);
            if ($this->option('t')) {
                $this->makeTest($name, '--model');
            }
        }

        if ($this->option('i') || $this->option('r') || $this->option('ra') || $this->option('a')) {
            parent::handle();
        } elseif ($this->option('ri') || $this->option('ir')) {
            $this->call('make:rep', ['name' => $name, '--i' => true]); //create interface
            $this->call('make:rep', ['name' => $name, '--r' => true]); //create abstract
        } else {
            if ($this->option('t')) {
                $this->makeTest($name, '--repository');
            }
            $this->call('make:rep', ['name' => $name, '--ra' => true]); //create repository extends abstract
            $this->call('make:rep', ['name' => $name, '--i' => true]); //create interface
            $this->call('make:rep', ['name' => $name, '--a' => true]); //create abstract

        }

        $this->call('rep:publish');

    }

    protected function makeTest($name, $type)
    {
        if (class_exists(\Yjtec\PHPUnit\ServiceProvider::class)) {
            $this->call('make:testy', ['name' => $name . 'Test', $type => true]);
        }
    }

    protected function getStub()
    {
        if ($this->option('i')) {
            return $this->resolveStubPath('/stubs/interface.stub');
        }

        if ($this->option('r')) {
            return $this->resolveStubPath('/stubs/repository.stub');
        }
        if ($this->option('ra')) {
            return $this->resolveStubPath('/stubs/repository.abstract.stub');
        }
        if ($this->option('a')) {
            return $this->resolveStubPath('/stubs/abstract.stub');
        }

    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $baseName = '';
        if ($this->option('i')) {
            $baseName = 'Interface';
        } elseif ($this->option('r') || $this->option('ra')) {
            $baseName = 'Repository';
        }

        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('app/') . str_replace('\\', '/', $name) . $baseName . '.php';
    }
    /**
     * Resolve the fully-qualified path to the stub.
     *
     * @param  string  $stub
     * @return string
     */
    protected function resolveStubPath($stub)
    {
        return file_exists($customPath = $this->laravel->basePath(trim($stub, '/')))
        ? $customPath
        : __DIR__ . $stub;
    }
    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        if ($this->option('a')) {
            return $rootNamespace . '\Repositories';
        } elseif ($this->option('i')) {
            return $rootNamespace . '\Repositories\Contracts';
        } elseif ($this->option('r') || $this->option('ra')) {
            return $rootNamespace . '\Repositories\Eloquent';
        }
    }
    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['i', 'interface', InputOption::VALUE_NONE, 'Create a interface.'],
            ['r', 'repository', InputOption::VALUE_NONE, 'Create a repository.'],
            ['ra', 'repositoryunderabstract', InputOption::VALUE_NONE, 'Create a repository with abstract.'],
            ['a', 'abstract', InputOption::VALUE_NONE, 'Create a abstract.'],
            ['ri', 'repositoryandinterface', InputOption::VALUE_NONE, 'Create a repository and interface.'],
            ['ir', 'interfaceandrepository', InputOption::VALUE_NONE, 'Create a interface and repository.'],
            ['mf', 'modelandfactory', InputOption::VALUE_NONE, 'Create a repository and model and factory'],
            ['m', 'model', InputOption::VALUE_NONE, 'Create a repository and model'],
            ['t', 'test', InputOption::VALUE_NONE, 'Create a repository or model with test'],
        ];
    }

}
