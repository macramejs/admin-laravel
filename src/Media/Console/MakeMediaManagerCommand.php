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
            'app'                    => $this->app(),
            'name'                   => $this->name(),
            'route'                  => $this->route(),
            'page'                   => $this->page(),
            'namespace'              => $this->namespace(),
            'time'                   => date('Y_m_d_His', time()),
            'file_model'             => $this->model(),
            'file_table'             => 'files',
            'file_attachments_table' => 'file_attachments',
            'file_attachment_model'  => 'FileAttachment',
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
    // media
    Route::get('/media', [MediaController::class, 'index'])->name('media.index');
    Route::get('/media/items', [MediaController::class, 'items'])->name('media.items');
    Route::get('/media/items/{file}', [MediaController::class, 'item'])->name('media.item');
    Route::post('/media/upload', [MediaController::class, 'upload'])->name('media.upload');
    Route::post('/media/delete', [MediaController::class, 'destroy'])->name('media.destroy');

    // media collections
    Route::post('/media', [MediaCollectionController::class, 'store'])->name('media-collections.show');
    Route::get('/media/{collection}', [MediaCollectionController::class, 'show'])->name('media-collections.show');
    Route::post('/media/{collection}/upload', [MediaCollectionController::class, 'upload'])->name('media-collections.upload');
    Route::post('/media/{collection}/remove', [MediaCollectionController::class, 'remove'])->name('media-collections.remove');
    Route::post('/media/{collection}/add', [MediaCollectionController::class, 'add'])->name('media-collections.add');";
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
            from: $this->publishesPath('resources/pages'),
            to: resource_path($this->app().'/js/Pages/'.$this->page())
        );

        // Modules
        $this->publishDir(
            from: $this->publishesPath('resources/modules'),
            to: resource_path($this->app().'/js/modules/'.$this->name())
        );

        // Types
        $page = $this->page();
        $insert = "// {$page}

export type {$page} = {
    id?: number,
    display_name: string,
    group: string,
    disk: string,
    filepath: string,
    filename: string,
    mimetype: string,
    size: number,
}
export type {$page}Resource = Resource<File>;

// {$page}Collection

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

        $insert = '// Media links
sidebarLinks.push({
    title: "Medien",
    href: "/admin/media",
    icon: "📷"
}); ';

        $this->insertAtEnd(
            resource_path($this->app().'/js/modules/sidebar-navigation/index.ts'),
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
