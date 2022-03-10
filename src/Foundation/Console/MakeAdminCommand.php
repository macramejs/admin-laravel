<?php

namespace Macrame\Admin\Foundation\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeAdminCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:admin';

    protected $publishes = 'admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame Admin application.';

    public function handle()
    {
        $this->makeApp();
        $this->makeResources();
        $this->makeRootFiles();

        $this->line("Created Macrame Admin application '".$this->name());
        $this->line("Just a view more steps to get started:\n");

        $this->line('1. Make sure the following npm packages are installed:');
        $this->info("npm i tailwindcss lodash.merge @headlessui/vue @macramejs/admin-vue3 @macramejs/admin-config @macramejs/admin-vue3 @macramejs/macrame @macramejs/macrame-vue3 @macramejs/page-builder-vue3 ts-loader typescript vue@next vue-loader@next @inertiajs/inertia @inertiajs/inertia-vue3 @inertiajs/progress vue3-dropzone vue3-popper v-calendar@next\n");

        $this->line('2. Make sure to update composers autoloader:');
        $this->info("composer dumpautoload\n");

        $this->line('3. Run the migrations and the seeder:');
        $this->info("php artisan migrate:fresh --seed\n");

        $this->line('4. Create a development build:');
        $this->info("npm run watch\n");

        $this->line('5. Visit '.url($this->name()).' and login using the following credentials:');
        $this->info('username: admin@admin.com');
        $this->info('password: secret');

        return 0;
    }

    protected function replaces(): array
    {
        return [
            'namespace'  => $this->namespace(),
            'name'       => $this->name(),
            'home-const' => $this->homeConst(),
            'time'       => date('Y_m_d_His', time()),
        ];
    }

    protected function makeApp()
    {
        $name = $this->name();

        // Create application files
        $this->publishDir(
            from: $this->publishesPath('app'),
            to: $this->appPath()
        );

        $this->publishFile(
            from: $this->publishesPath('routes/routes.php'),
            to: base_path("routes/{$name}.php")
        );

        // Add migration
        $this->publishDir(
            from: $this->publishesPath('migrations'),
            to: database_path('migrations'),
        );

        // Add to seeder
        $file = database_path('seeders/DatabaseSeeder.php');
        $insert = "        \App\Models\User::factory()->create([
            'password' => bcrypt('secret'),
            'email'    => '{$name}@{$name}.com',
            'is_{$name}' => true,
        ]);";
        $after = 'public function run()
    {';
        $this->insertAfter($file, $insert, $after);

        // Add routes
        $file = app_path('Providers/RouteServiceProvider.php');
        $insert = "
            Route::middleware('web')
                ->prefix('{$name}')
                ->as('{$name}.')
                ->namespace(\$this->namespace)
                ->group(base_path('routes/{$name}.php'));";

        $after = "->group(base_path('routes/web.php'));";

        $this->insertAfter($file, $insert, $after);

        // Add admin home
        $file = app_path('Providers/RouteServiceProvider.php');
        $insert = "
    /**
     * The path to the {$name} dashboard of your application.
     *
     * This is used by Laravel authentication to redirect users after login.
     *
     * @var string
     */
    public const ".$this->homeConst()." = '/{$name}';";
        $after = "public const HOME = '/home';";

        $this->insertAfter($file, $insert, $after);

        // Publish Laravel breeze's LoginRequest
        if (! class_exists(\App\Http\Requests\Auth\LoginRequest::class)) {
            $this->files->ensureDirectoryExists(app_path('Http/Requests/Auth'));
            $this->files->copyDirectory(
                base_path('vendor/laravel/breeze/stubs/default/App/Http/Requests/Auth'),
                app_path('Http/Requests/Auth')
            );
        }
    }

    protected function makeResources()
    {
        // Create view file
        $this->publishFile(
            from: $this->publishesPath('views/app.blade.php'),
            to: resource_path('views/'.$this->viewName())
        );

        // Create resource files
        $this->publishDir(
            from: $this->publishesPath('resources'),
            to: $this->resourcesDir()
        );
    }

    protected function makeRootFiles()
    {
        $name = $this->name();
        $namespace = $this->namespace();

        // tailwind config
        $this->publishFile(
            from: $this->publishesPath('root/tailwind.config.js'),
            to: base_path("{$name}.tailwind.config.js"),
        );

        // shims-vue
        $this->publishFile(
            from: $this->publishesPath('root/shims-vue.d.ts'),
            to: base_path('shims-vue.d.ts'),
        );

        // tsconfig
        $this->publishFile(
            from: $this->publishesPath('root/tsconfig.json'),
            to: base_path('tsconfig.json'),
        );

        // webpack.mix.js
        $insert = "// {$namespace}-App
mix.ts('resources/{$name}/js/app.ts', 'public/js/{$name}').vue();
mix.postCss('resources/{$name}/css/app.css', 'public/css/{$name}', [
    tailwindcss('./{$name}.tailwind.config.js'),
]);
mix.alias({
    '@{$name}': path.join(__dirname, 'resources/{$name}/js'),
});";
        $this->insertAtEnd(base_path('webpack.mix.js'), $insert);

        $insert = "const path = require('path');";
        $after = "const mix = require('laravel-mix');";
        $this->insertAfter(base_path('webpack.mix.js'), $insert, $after);

        $insert = "const tailwindcss = require('tailwindcss')";
        $after = "const mix = require('laravel-mix');";
        $this->insertAfter(base_path('webpack.mix.js'), $insert, $after);

        // composer.json
        $composer = json_decode(
            $this->files->get(base_path('composer.json')),
            true
        );
        $composer['autoload']['psr-4']["{$namespace}\\"] = "{$name}/";
        $this->files->put(
            base_path('composer.json'),
            json_encode($composer, JSON_PRETTY_PRINT + JSON_UNESCAPED_SLASHES)
        );
    }

    protected function viewName()
    {
        return $this->name().'.blade.php';
    }

    protected function resourcesDir()
    {
        return resource_path($this->name());
    }

    protected function appPath($path = '')
    {
        return base_path(lcfirst($this->argument('name'))).($path != '' ? DIRECTORY_SEPARATOR.$path : '');
    }

    protected function namespace()
    {
        return ucfirst(Str::kebab($this->argument('name')));
    }

    protected function name()
    {
        return Str::kebab($this->argument('name'));
    }

    protected function homeConst()
    {
        return strtoupper($this->name()).'_HOME';
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
            ['name', InputArgument::REQUIRED, 'The name of the Admin application.'],
        ];
    }
}
