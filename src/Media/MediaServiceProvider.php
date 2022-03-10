<?php

namespace Macrame\Admin\Media;

use Illuminate\Support\ServiceProvider;
use Macrame\Admin\Media\Console\MakeMediaManagerCommand;

class MediaServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'MakeMediaManager' => MakeMediaManagerCommand::class,
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
    protected function registerMakeMediaManagerCommand()
    {
        $this->app->singleton(MakeAdminCommand::class, function ($app) {
            return new MakeMediaManagerCommand($app['files']);
        });
    }
}
