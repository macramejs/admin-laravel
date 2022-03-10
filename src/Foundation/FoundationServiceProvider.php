<?php

namespace Macrame\Admin\Foundation;

use Illuminate\Support\ServiceProvider;
use Macrame\Admin\Foundation\Console\MakeAdminCommand;
use Macrame\Admin\Media\MediaServiceProvider;

class FoundationServiceProvider extends ServiceProvider
{
    /**
     * The commands to be registered.
     *
     * @var array
     */
    protected $commands = [
        'MakeAdmin' => MakeAdminCommand::class,
    ];

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->registerCommands($this->commands);

        //
        $this->app->register(MediaServiceProvider::class);
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
    protected function registerMakeAdminCommand()
    {
        $this->app->singleton(MakeAdminCommand::class, function ($app) {
            return new MakeAdminCommand($app['files']);
        });
    }
}
