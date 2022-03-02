<?php

namespace Macrame\CMS\Foundation\Console;

use Illuminate\Support\Str;
use Symfony\Component\Console\Input\InputArgument;

class MakeCmsCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:cms';

    protected $publishes = 'cms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame CMS application.';

    public function handle()
    {
        $this->makeApp();
        $this->makeResources();
        $this->makeRootFiles();

        return 0;
    }

    protected function replaces(): array
    {
        return [
            'namespace'  => $this->namespace(),
            'name'       => $this->name(),
            'home-const' => $this->homeConst(),
        ];
    }

    protected function makeApp()
    {
        $name = $this->name();

        // Create application files
        $this->publishDir(
            from: $this->publishesPath('app'),
            to: $this->appDir()
        );

        $this->publishFile(
            from: $this->publishesPath('routes/routes.php'),
            to: base_path("routes/{$name}.php")
        );

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
        $this->publishFile(
            from: $this->publishesPath('root/tailwind.config.js'),
            to: base_path($this->name().'.tailwind.config.js'),
        );

        $name = $this->name();
        $app = $this->namespace();
        $this->insertAtEnd(base_path($this), "
// {$app}-App
mix.ts('resources/{$name}/js/app.ts', 'public/js/{$name}').vue();
mix.postCss('resources/{$name}/css/app.css', 'public/css/{$name}', [
    tailwindcss('./{$name}.tailwind.config.js'),
]);
mix.alias({
    '@{$name}': path.join(__dirname, 'resources/{$name}/js'),
});
");
    }

    protected function viewName()
    {
        return $this->name().'.blade.php';
    }

    protected function resourcesDir()
    {
        return $this->name();
    }

    protected function appDir()
    {
        return lcfirst($this->argument('name'));
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
            ['name', InputArgument::REQUIRED, 'The name of the CMS application.'],
        ];
    }
}
