<?php

namespace Macrame\Admin\Nav;

use Illuminate\Support\ServiceProvider;
use Macrame\Admin\Nav\Console\MakeNavBuilderCommand;

class NavServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'MakeNavBuilder' => MakeNavBuilderCommand::class,
    ];

    /**
     * Register application services.
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
     * Regsiter make:admin command.
     *
     * @return void
     */
    protected function registerMakeNavBuilderCommand()
    {
        $this->app->singleton(MakeNavBuilderCommand::class, function ($app) {
            return new MakeNavBuilderCommand($app['files']);
        });
    }
}
