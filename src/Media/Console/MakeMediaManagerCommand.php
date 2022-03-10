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
            'file_model'            => $this->model(),
            'file_table'            => 'files',
            'file_attachment_table' => 'file_attachments',
            'file_attachment_model' => 'FileAttachment',
        ];
    }

    protected function model()
    {
        return 'File';
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
        $page = $this->page();
        $route = $this->route();
        $insert = "
    // {$name}
    Route::get('/{$route}', [{$page}Controller::class, 'index'])->name('{$route}.index');
    Route::get('/{$route}/items', [{$page}Controller::class, '{$route}'])->name('{$route}.{$route}');
    Route::post('/{$route}/upload', [{$page}Controller::class, 'upload'])->name('{$route}.upload');

    // {$name} collections
    Route::post('/{$route}', [{$page}CollectionController::class, 'store'])->name('{$name}-collections.show');
    Route::get('/{$route}/{collection}', [{$page}CollectionController::class, 'show'])->name('{$name}-collections.show');
    Route::post('/{$route}/{collection}/upload', [{$page}CollectionController::class, 'upload'])->name('{$name}-collections.upload');";
        $before = '});';

        $routesPath = base_path('routes/'.$this->app().'.php');
        $this->insertBefore($routesPath, $insert, $before);

        $insert = "use Admin\Http\Controllers\\{$page}CollectionController;
use Admin\Http\Controllers\\{$page}Controller;";
        $before = "use Illuminate\Support\Facades\Route;";

        $this->insertBefore($routesPath, $insert, $before);
    }

    protected function makeResourcesFiles()
    {
        // Pages
        $this->publishDir(
            from: $this->publishesPath('resources/Pages'),
            to: resource_path($this->app().'/js/Pages/'.$this->page())
        );

        // Types
        $model = $this->model();
        $page = $this->page();
        $insert = "export type {$model} = {
    id?: number,
    display_name: string,
    group: string,
    disk: string,
    filepath: string,
    filename: string,
    mimetype: string,
    size: number,
}
export type {$model}Resource = Resource<File>;
export type {$model}CollectionResource = CollectionResource<File>;

export type {$page}Collection = {
    id?: number,
    title: string,
    key?: string,
}
export type {$page}CollectionResource = Resource<{$page}Collection>;
export type {$page}CollectionCollectionResource = CollectionResource<{$page}Collection>;";
        $this->insertAtEnd(
            resource_path($this->app().'/js/types/resources.ts'),
            $insert
        );
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
