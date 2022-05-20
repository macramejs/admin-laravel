<?php

namespace Macrame\Admin\Pages\Console;

use Illuminate\Support\Str;
use Macrame\Admin\Foundation\Console\BaseMakeCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakePageBuilderCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:page-builder';

    /**
     * The name of the publishes directory.
     *
     * @var string
     */
    protected $publishes = 'pages';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame Admin page builder.';

    /**
     * Handle the execution of the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->makeAppFiles();
        $this->makeResourcesFiles();

        return 0;
    }

    /**
     * The attributes that should be replaced.
     *
     * @return array
     */
    protected function replaces(): array
    {
        return [
            'app'       => $this->app(),
            'name'      => $this->name(),
            'route'     => $this->route(),
            'page'      => $this->page(),
            'namespace' => $this->namespace(),
            'time'      => date('Y_m_d_His', time()),
            'model'     => $this->model(),
            'table'     => $this->tableName(),
        ];
    }

    protected function model()
    {
        return ucfirst(Str::camel($this->argument('name')));
    }

    protected function tableName()
    {
        return Str::snake(Str::plural($this->argument('name')));
    }

    protected function makeAppFiles()
    {
        // Admin-Controllers
        $this->publishDir(
            from: $this->publishesPath('app/controllers'),
            to: $this->appPath('Http/Controllers')
        );
        // App-Controllers
        $this->publishDir(
            from: $this->publishesPath('controllers'),
            to: app_path('Http/Controllers')
        );
        // Casts
        $this->publishDir(
            from: $this->publishesPath('app/casts'),
            to: app_path('Casts')
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

        $model = $this->model();
        $app = $this->app();
        $insert = "
            {$model}::routes();";
        $after = "->group(base_path('routes/web.php'));";

        $providerPath = app_path('Providers/RouteServiceProvider.php');
        $this->insertAfter($providerPath, $insert, $after);

        $insert = "use App\Models\\{$model};";
        $before = "use Illuminate\Http\Request;";
        $this->insertBefore($providerPath, $insert, $before);

        $insert = "\nuse App\Http\Controllers\\{$model}Controller;";
        $after = "namespace App\Providers;";

        $this->insertAfter($providerPath, $insert, $after);

        $route = $this->route();
        $insert = "
    // pages
    Route::get('/pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('/pages/items', [PageController::class, 'items'])->name('pages.items');
    Route::get('/pages/{page}/{tab?}', [PageController::class, 'show'])->name('pages.show');
    Route::delete('/pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy');
    Route::post('/pages', [PageController::class, 'store'])->name('pages.store');
    Route::post('/pages/order', [PageController::class, 'order'])->name('pages.order');
    Route::put('/pages/{page}', [PageController::class, 'update'])->name('pages.update');
    Route::post('/pages/{page}/meta', [PageController::class, 'meta'])->name('pages.meta');
    Route::post('/pages/{page}/upload', [PageController::class, 'upload'])->name('pages.upload');";
        $before = '});';

        $routesPath = base_path('routes/'.$this->app().'.php');
        $this->insertBefore($routesPath, $insert, $before);

        $insert = "use Admin\Http\Controllers\\{$model}Controller;";
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
        $this->publishDir(
            from: $this->publishesPath('resources/modules'),
            to: resource_path($this->app().'/js/modules')
        );

        // Types
        $model = $this->model();
        $insert = "// {$model}

export type {$model} = {
    content: { [key: string]: any };
    attributes: { [key: string]: any };
    id?: number;
    name: string;
    slug: string;
    template: string;
    full_slug: string;
    meta: {
        title: string;
        description: string;
    };
};

export type {$model}TreeItem = RawTreeItem<{$model}>;
export type {$model}Resource = Resource<{$model}>;
export type {$model}CollectionResource = CollectionResource<{$model}>;
export type {$model}TreeResource = Resource<{$model}TreeItem>;
export type {$model}TreeCollectionResource = CollectionResource<{$model}TreeItem>;";
        $this->insertAtEnd(
            resource_path($this->app().'/js/types/resources.ts'),
            $insert
        );

        $this->insertAtStart(
            resource_path($this->app().'/js/types/resources.ts'),
            'import { RawTreeItem } from "@macramejs/macrame-vue3";'
        );

        $insert = "// {$model}

export type {$model}Content = {
    name: string,
    content: {[k:string]: any}[],
    attributes: {[k:string]: any}
}
export type {$model}ContentForm = Form<{$model}Content>;

export type {$model}Meta = {
    title: string,
    description: string
}
export type {$model}MetaForm = Form<{$model}Meta>;";
        $this->insertAtEnd(
            resource_path($this->app().'/js/types/forms.ts'),
            $insert
        );

        $this->insertAtStart(
            resource_path($this->app().'/js/modules/sidebar-navigation/index.ts'),
            'import { IconPages } from \'@macramejs/admin-vue3\';'
        );
        $insert = '// Pages links
sidebarLinks.push({
    title: "Seiten",
    href: "/admin/pages",
    icon: IconPages
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
            ['name', InputArgument::REQUIRED, 'The name of the page builder.'],
        ];
    }
}
