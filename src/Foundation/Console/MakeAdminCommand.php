<?php

namespace Macrame\Admin\Foundation\Console;

use Symfony\Component\Process\Process;

class MakeAdminCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:admin';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Admin application.';

    /**
     * The module that is being published.
     *
     * @var string
     */
    protected $publishesModule = 'admin';

    public function handle()
    {
        // $this->publishModule($this->publishesModule);

        // Copy Admin files
        $this->files->ensureDirectoryExists(base_path('admin'));
        $this->files->copyDirectory($this->publishesPath('admin'), base_path('admin'));
        $this->files->copyDirectory($this->publishesPath('routes'), base_path('routes'));

        // Copy App files
        $this->files->copyDirectory($this->publishesPath('app'), app_path());

        // Copy CORS Configuration
        $this->files->copyDirectory($this->publishesPath('config'), config_path());
        $this->files->copyDirectory($this->publishesPath('migrations'), database_path('migrations'));

        // Register (pages) Routes
        $this->replaceInFile(
            "namespace App\Providers;\n",
            "namespace App\Providers;\n\nuse App\Models\Page;",
            app_path('providers/RouteServiceProvider.php')
        );
        $this->replaceInFile(
            "                ->group(base_path('routes/web.php'));",
            "                ->group(base_path('routes/web.php'));
            
            Page::routes();
            
            Route::prefix('admin')
                ->group(base_path('routes/admin.php'));",
            app_path('providers/RouteServiceProvider.php')
        );

        // add RateLimiting for admin api
        $this->replaceInFile(
            "RateLimiter::for('api', function (Request \$request) {",
            "RateLimiter::for('api', function (Request \$request) {
            if (str_contains(\$request->getRequestUri(), 'admin/api') && \$request->user()) {
                return Limit::perMinute(600)->by(\$request->user()->id);
            }\n",
            app_path('providers/RouteServiceProvider.php')
        );

        // add admin psr namespace
        $this->replaceInFile(
            '            "App\\\\": "app/",',
            '            "App\\\\": "app/",
            "Admin\\\\": "admin/",',
            base_path('composer.json')
        );

        $this->addAppRoutes();

        $this->addComposerDependencies();
        $this->configureEnvironment();

        return 0;
    }

    protected function configureEnvironment()
    {
        $appDomain = parse_url(url('/'))['host'];

        if ($this->confirm("Is your admin backend located at admin.$appDomain?", true)) {
            $this->replaceInFile(
                'SESSION_LIFETIME=120',
                "SESSION_LIFETIME=120\n\nSANCTUM_STATEFUL_DOMAINS=localhost,admin.{$appDomain}\nSESSION_DOMAIN=.{$appDomain}",
                base_path('.env')
            );
        }
    }

    protected function addAppRoutes()
    {
        $routes = [
            'web' => [
                'App\Http\Controllers\MediaController' => "Route::get('/storage/c/{id}/{file}', [MediaController::class, 'conversion']);",
            ],
        ];

        foreach ($routes as $file => $fileRoutes) {
            $filePath = base_path("routes/{$file}.php");

            foreach ($fileRoutes as $controller => $route) {
                if (str_contains(file_get_contents($filePath), $controller)) {
                    continue;
                }

                $this->replaceInFile(
                    "<?php\n",
                    "<?php\n\nuse {$controller};",
                    $filePath
                );

                $this->replaceInFile(
                    '});',
                    "});\n{$route}",
                    $filePath
                );
            }
        }
    }

    protected function addComposerDependencies()
    {
        $composerPackages = [
            'laravel/sanctum',
            'macramejs/macrame-laravel:dev-main',
            'owen-it/laravel-auditing',
            'intervention/image',
            'intervention/imagecache',
        ];

        (new Process(['composer', 'require'] + $composerPackages, base_path()))
            ->setTimeout(null)
            ->run(function ($type, $output) {
                $this->output->write($output);
            });
    }

    protected function replaceInFile($search, $replace, $path)
    {
        file_put_contents($path, str_replace($search, $replace, file_get_contents($path)));
    }
}
