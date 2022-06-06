<?php

namespace Macrame\Admin\Nav\Console;

use Illuminate\Support\Str;
use Macrame\Admin\Foundation\Console\BaseMakeCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeNavBuilderCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:nav-builder';

    protected $publishes = 'nav';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame Admin navigation builder.';

    public function handle()
    {
        $this->makeAppFiles();
        $this->makeResourcesFiles();

        return 0;
    }

    protected function replaces(): array
    {
        return [
            'app'       => $this->app(),
            'route'     => $this->route(),
            'namespace' => $this->namespace(),
            'time'      => date('Y_m_d_His', time()),
        ];
    }

    protected function makeAppFiles()
    {
        // Controllers
        $this->publishDir(
            from: $this->publishesPath('app/controllers'),
            to: $this->appPath('Http/Controllers')
        );

        // Admin Resources
        $this->publishDir(
            from: $this->publishesPath('app/admin_resources'),
            to: $this->appPath('Http/Resources')
        );

        // App Resources
        $this->files->ensureDirectoryExists(app_path('Http/Resources'));
        $this->publishDir(
            from: $this->publishesPath('app/app_resources'),
            to: app_path('Http/Resources')
        );

        // Casts
        $this->files->ensureDirectoryExists(app_path('Casts'));
        $this->publishDir(
            from: $this->publishesPath('app/casts'),
            to: app_path('Casts')
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

        $route = $this->route();
        $namespace = $this->namespace();
        $insert = "
    // nav
    Route::get('/{$route}', [NavController::class, 'index'])->name('nav.index');
    Route::get('/{$route}/{type}', [NavController::class, 'show'])->name('nav.show');
    Route::post('/{$route}/{type}', [NavController::class, 'store'])->name('nav.store');
    Route::put('/{$route}/{type}/{item}', [NavController::class, 'update'])->name('nav.update');
    Route::post('/{$route}/{type}/order', [NavController::class, 'order'])->name('nav.order');
    Route::delete('/{$route}/{type}/{item}', [NavController::class, 'destroy'])->name('nav.item.delete');";
        $before = '});';

        $routesPath = base_path('routes/'.$this->app().'.php');
        $this->insertBefore($routesPath, $insert, $before);

        $insert = "use {$namespace}\Http\Controllers\NavController;";
        $before = "use Illuminate\Support\Facades\Route;";

        $this->insertBefore($routesPath, $insert, $before);
    }

    protected function makeResourcesFiles()
    {
        // Pages
        $this->publishDir(
            from: $this->publishesPath('resources/Pages'),
            to: resource_path($this->app().'/js/Pages/Nav')
        );

        // Modules
        $this->publishDir(
            from: $this->publishesPath('resources/modules'),
            to: resource_path($this->app().'/js/modules/nav')
        );

        // Types
        $insert = '// Nav

export type NavItem = {
    id?: number,
    title: string,
    link: string,
    children: NavItem[],
}
export type NavItemTreeItem = RawTreeItem<NavItem>;
export type NavItemTreeResource = Resource<NavItemTreeItem>;
export type NavItemTreeCollectionResource = CollectionResource<NavItemTreeItem>;

export type LinkOption = {
    link: string,
    title: string,
}
export type LinkOptionResource = Resource<LinkOption>;
export type LinkOptionCollectionResource = CollectionResource<LinkOption>;';
        $this->insertAtEnd(
            resource_path($this->app().'/js/types/resources.ts'),
            $insert
        );

        $this->insertAtStart(
            resource_path($this->app().'/js/types/resources.ts'),
            'import { RawTreeItem } from "@macramejs/macrame-vue3";'
        );

        $this->insertAtStart(
            resource_path($this->app().'/js/types/forms.ts'),
            'import { Form } from \'@macramejs/macrame-vue3\';'
        );

        $insert = '// NavItem
        export type NavItemForm = Form<NavItem>;';

        $this->insertAtEnd(
            resource_path($this->app().'/js/types/forms.ts'),
            $insert
        );

        $this->insertAtStart(
            resource_path($this->app().'/js/modules/sidebar-navigation/index.ts'),
            'import { IconList } from \'@macramejs/admin-vue3\';'
        );

        $insert = '// Navigation links
sidebarLinks.push({
    title: "Navigation",
    href: "/admin/nav",
    icon: IconList,
}); ';

        $this->insertAtEnd(
            resource_path($this->app().'/js/modules/sidebar-navigation/index.ts'),
            $insert
        );
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

    protected function route()
    {
        return 'nav';
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
        ];
    }
}
