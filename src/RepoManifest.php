<?php

/**
 * @Author: kidkang
 * @Date:   2021-03-07 00:32:59
 * @Last Modified by:   kidkang
 * @Last Modified time: 2021-03-07 02:47:28
 */
namespace Yjtec\Repo;

use Exception;
use Illuminate\Contracts\Foundation\Application as ApplicationContract;
use Illuminate\Filesystem\Filesystem;

class RepoManifest
{
    /**
     * The application implementation.
     *
     * @var \Illuminate\Contracts\Foundation\Application
     */
    protected $app;
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    public $files;

    /**
     * The base path.
     *
     * @var string
     */
    public $basePath;

    /**
     * The manifest path.
     *
     * @var string|null
     */
    public $manifestPath;

    /**
     * The loaded manifest array.
     *
     * @var array
     */
    public $manifest;

    /**
     * Create a new repo manifest instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem  $files
     * @param  string  $basePath
     * @param  string  $manifestPath
     * @return void
     */
    public function __construct(ApplicationContract $app, Filesystem $files, $basePath)
    {
        $this->app = $app;
        $this->files = $files;
        $this->basePath = $basePath;
        $this->manifestPath = $this->getManifestPath();
    }

    protected function getManifestPath()
    {
        return dirname($this->app->getCachedServicesPath()) . DIRECTORY_SEPARATOR . 'repositories.php';
    }

    /**
     * Get the current package manifest.
     *
     * @return array
     */
    protected function getManifest()
    {
        if (!is_null($this->manifest)) {
            return $this->manifest;
        }

        if (!is_file($this->manifestPath)) {
            $this->build();
        }

        return $this->manifest = is_file($this->manifestPath) ?
        $this->files->getRequire($this->manifestPath) : [];
    }

    public function bind()
    {
        if ($repos = $this->getManifest()) {
            foreach ($repos as $interface => $eloquent) {
                $this->app->bind($interface, $eloquent);
            }
        }
    }

    public function build()
    {
        $abstractRepo = $this->getAbstractRepo();
        $interfaceRepo = $this->getInterfaceRepo();
        $this->write($abstractRepo + $interfaceRepo);
    }
    protected function getInterfaceRepo()
    {
        if (is_dir($path = $this->basePath . '/Contracts')) {
            return collect($this->files->files($path))->map(function ($file) {
                return $this->formatFile(str_replace('Interface', '', $file->getFilename()));
            })->filter(function ($item) {
                return $item['extension'] == 'php' && $this->hasRepositoryFile($item['name']);
            })->mapWithKeys(function ($item) {
                return $this->formatInterface($item['name']);
            })->all();
        }
    }
    protected function getAbstractRepo()
    {
        if (is_dir($this->basePath)) {
            return collect($this->files->files($this->basePath))->map(function ($file) {
                return $this->formatFile($file->getFilename());
            })->filter(function ($item) {
                return $item['extension'] == 'php' && $this->hasRepositoryFile($item['name']);
            })->mapWithKeys(function ($item) {
                return $this->format($item['name']);
            })->all();
        }
        return [];
    }

    protected function hasRepositoryFile($name)
    {
        return is_file($this->basePath . '/Eloquent/' . $name . 'Repository.php');
    }

    protected function formatFile($filename)
    {
        $arr = explode('.', $filename);
        $name = $arr[0];
        $extension = isset($arr[1]) ? $arr[1] : '';
        return ['name' => $name, 'extension' => $extension];
    }

    protected function format($name)
    {
        return ['App\\Repositories\\' . $name => 'App\\Repositories\\Eloquent\\' . $name . 'Repository'];
    }

    protected function formatInterface($name)
    {
        return ['App\\Repositories\\Contracts\\' . $name . 'Interface' => 'App\\Repositories\\Eloquent\\' . $name . 'Repository'];
    }

    public function write($manifest)
    {
        if (!is_writable($dirname = dirname($this->manifestPath))) {
            throw new Exception("The {$dirname} directory must be present and writable.");
        }

        $this->files->replace(
            $this->manifestPath, '<?php return ' . var_export($manifest, true) . ';'
        );
    }
}
