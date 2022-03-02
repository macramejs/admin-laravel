<?php

namespace Macrame\CMS\Foundation;

use Illuminate\Support\ServiceProvider;
use Macrame\CMS\Foundation\Console\MakeCmsCommand;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'MakeCms' => MakeCmsCommand::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands($this->commands);
    }

    /**
     * Register the given commands.
     *
     * @param  array $commands
     * @return void
     */
    protected function registerCommands(array $commands)
    {
        foreach (array_keys($commands) as $command) {
            $this->{"register{$command}Command"}();
        }

        $this->commands(array_values($commands));
    }

    /**
     * Regsiter make:cms command.
     *
     * @return void
     */
    protected function registerMakeCmsCommand()
    {
        $this->app->singleton(MakeCmsCommand::class, function ($app) {
            return new MakeCmsCommand($app['files']);
        });
    }
}
