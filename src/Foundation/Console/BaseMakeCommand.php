<?php

namespace Macrame\Admin\Foundation\Console;

use Closure;
use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use LogicException;
use RecursiveDirectoryIterator;
use RecursiveIteratorIterator;
use SplFileInfo;

abstract class BaseMakeCommand extends Command
{
    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new controller creator command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    public function publishesPath($path)
    {
        return __DIR__.'/../../../publishes/'.$path;
    }

    public function publishModule(string $module)
    {
        $this->publishTypeForModule($module, 'admin');
        $this->publishTypeForModule($module, 'app');
        $this->publishTypeForModule($module, 'migrations');

        $this->publishModuleRoutes($module);
    }

    public function publishModuleRoutes($module)
    {
        // code...
    }

    public function publishTypeForModule($module, $type)
    {
        $this->forEachFile($this->publishesPath($type), function (SplFileInfo $file) use ($module, $type) {
            if ($file->getFilename() == '.' || $file->getFilename() == '..') {
                return;
            }

            dump($file->getFilename());

            if ($this->getModule($file) != $module) {
                return;
            }

            $destinationPath = $this->getDestinationPath($file, $type);

            $this->files->copy($file->getPath(), $destinationPath);
        });
    }

    protected function getModule(SplFileInfo $file)
    {
        $content = $this->files->get($file->getRealPath());

        preg_match('/@module\s+([a-zA-Z]+)/', $content, $matches);

        if (! $module = ($matches[1] ?? false)) {
            throw new LogicException("Missing module for in {$file}");
        }

        return $module;
    }

    protected function getDestinationPath(SplFileInfo $file, $type)
    {
        return match ($type) {
            'admin'      => base_path('admin/'.last(explode('publishes/admin/', $file->getPath()))),
            'app'        => app_path(last(explode('publishes/app/', $file))),
            'migrations' => database_path('migrations/'.last(explode('publishes/migrations/', $file)))
        };
    }

    protected function forEachFile(string $path, Closure $closure)
    {
        $directoryIterator = new RecursiveDirectoryIterator($path);

        collect(new RecursiveIteratorIterator($directoryIterator))->each($closure);
    }
}
