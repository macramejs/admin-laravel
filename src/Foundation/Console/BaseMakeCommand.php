<?php

namespace Macrame\Admin\Foundation\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Str;
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

    abstract protected function replaces(): array;

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

    protected function publishesPath($path = '')
    {
        return __DIR__."/../../../publishes/{$this->publishes}/".($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    protected function publishFile($from, $to)
    {
        $this->files->copy($from, $to);

        $this->applyReplacesToContent($to);
    }

    protected function publishDir($from, $to)
    {
        $this->files->ensureDirectoryExists($from);

        $this->files->copyDirectory($from, $to);

        $directoryIterator = new RecursiveDirectoryIterator($to);

        collect(new RecursiveIteratorIterator($directoryIterator))
            ->each(function (SplFileInfo $file) {
                if (! $file->isDir()) {
                    $this->applyReplacesToContent($file);
                }

                $this->applyReplacesToName($file);
            });
    }

    protected function applyReplacesToName(string $file)
    {
        $baseName = basename($file);

        foreach ($this->replaces() as $name => $replace) {
            $baseName = str_replace('{{ '.$name.' }}', $replace, $baseName);
        }

        if ($baseName == basename($file)) {
            return;
        }

        $newFile = Str::replaceLast(basename($file), $baseName, $file);

        $this->files->move($file, $newFile);
    }

    protected function applyReplacesToContent(string $file)
    {
        $content = $this->files->get($file);

        foreach ($this->replaces() as $name => $replace) {
            $content = str_replace('{{ '.$name.' }}', $replace, $content);
        }

        $this->files->put($file, $content);
    }

    /**
     * Insert code in the given file.
     *
     * @param  string $path
     * @param  string $insert
     * @param  string $after
     * @return void
     */
    protected function insertAfter(string $path, string $insert, string $after)
    {
        $content = $this->files->get($path);

        if (str_contains($content, $insert)) {
            return;
        }
        $content = str_replace($after, $after.PHP_EOL.$insert, $content);

        $this->files->put($path, $content);

        $this->info("{$path} changed, please check it for correction and formatting.");
    }

    /**
     * Insert code at the end of the given file.
     *
     * @param  string $path
     * @param  string $insert
     * @return void
     */
    protected function insertAtEnd(string $path, string $insert)
    {
        $content = $this->files->get($path);

        $this->files->put($path, "{$content}\n\n{$insert}");

        $this->info("{$path} changed, please check it for correction and formatting.");
    }
}
