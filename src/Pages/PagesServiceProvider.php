<?php

namespace Macrame\Admin\Pages;

use Illuminate\Support\ServiceProvider;
use Macrame\Admin\Pages\Console\MakePageBuilderCommand;

class PagesServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'MakePageBuilder' => MakePageBuilderCommand::class,
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
    protected function registerMakePageBuilderCommand()
    {
        $this->app->singleton(MakePageBuilderCommand::class, function ($app) {
            return new MakePageBuilderCommand($app['files']);
        });
    }
}
