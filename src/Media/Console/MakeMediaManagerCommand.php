<?php

namespace Macrame\Admin\Media\Console;

use Illuminate\Support\Str;
use Macrame\Admin\Foundation\Console\BaseMakeCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeMediaManagerCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:media-manager';

    protected $publishes = 'media';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame Admin media manager.';

    public function handle()
    {
        $this->makeAppFiles();
        $this->makeResourcesFiles();

        return 0;
    }

    protected function replaces(): array
    {
        return [
            'app'                   => $this->app(),
            'name'                  => $this->name(),
            'page'                  => $this->page(),
            'namespace'             => $this->namespace(),
            'time'                  => date('Y_m_d_His', time()),
            'file_model'            => 'File',
            'file_table'            => 'files',
            'file_attachment_table' => 'file_attachments',
            'file_attachment_model' => 'FileAttachment',
        ];
    }

    protected function makeAppFiles()
    {
        // Controllers
        $this->publishDir(
            from: $this->publishesPath('app/controllers'),
            to: $this->appPath('Http/Controllers')
        );

        // Indexes
        $this->publishDir(
            from: $this->publishesPath('app/indexes'),
            to: $this->appPath('Http/Indexes')
        );

        // Resources
        $this->publishDir(
            from: $this->publishesPath('app/resources'),
            to: $this->appPath('Http/Resources')
        );

        // Migrations
        $this->publishDir(
            from: $this->publishesPath('migrations'),
            to: database_path('migrations')
        );

        // Models
        $this->publishDir(
            from: $this->publishesPath('app/models'),
            to: app_path('Models')
        );

        $name = $this->name();
        $route = $this->route();
        $insert = "
    // {$name}
    Route::get('/{$route}', [FileController::class, 'index'])->name('{$route}.index');
    Route::get('/{$route}/items', [FileController::class, '{$route}'])->name('{$route}.{$route}');
    Route::post('/{$route}/upload', [FileController::class, 'upload'])->name('{$route}.upload');

    // {$name} collections
    Route::post('/{$route}', [FileCollectionController::class, 'store'])->name('{$name}-collections.show');
    Route::get('/{$route}/{collection}', [FileCollectionController::class, 'show'])->name('{$name}-collections.show');
    Route::post('/{$route}/{collection}/upload', [FileCollectionController::class, 'upload'])->name('{$name}-collections.upload');";
        $before = ')};';

        $this->insertBefore(base_path('routes/'.$this->app().'.php'), $insert, $before);
    }

    protected function makeResourcesFiles()
    {
        // Pages
        $this->publishDir(
            from: $this->publishesPath('resources/Pages'),
            to: resource_path($this->app().'/js/Pages/'.$this->page())
        );

        // Types
        $insert = 'export type File = {
    id?: number,
    display_name: string,
    group: string,
    disk: string,
    filepath: string,
    filename: string,
    mimetype: string,
    size: number,
}

export type FileCollection = {
    id?: number,
    title: string,
    key?: string,
}';
    }

    protected function resourcesDir()
    {
        return $this->name();
    }

    protected function appPath($path = '')
    {
        return base_path(lcfirst($this->app())).($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    protected function namespace()
    {
        return ucfirst(Str::camel($this->argument('app')));
    }

    protected function app()
    {
        return Str::kebab($this->argument('app'));
    }

    protected function page()
    {
        return ucfirst(Str::camel($this->argument('name')));
    }

    protected function name()
    {
        return Str::kebab($this->argument('name'));
    }

    protected function route()
    {
        return Str::kebab(Str::plural($this->argument('name')));
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            // ['all', 'a', InputOption::VALUE_NONE, 'Generate a migration, seeder, factory, policy, and resource controller for the model'],
            // ['controller', 'c', InputOption::VALUE_NONE, 'Create a new controller for the model'],
        ];
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['app', InputArgument::REQUIRED, 'The name of the admin application.'],
            ['name', InputArgument::REQUIRED, 'The name of the media manager.'],
        ];
    }
}
