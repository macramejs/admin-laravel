<?php

namespace Macrame\Admin\Media\Console;

use Illuminate\Support\Str;
use Macrame\Admin\Foundation\Console\BaseMakeCommand;
use Symfony\Component\Console\Input\InputArgument;

class MakeMediaManagerCommand extends BaseMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'make:media-manager';

    protected $publishes = 'media-manager';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame Admin media-manager.';

    public function handle()
    {
        $this->makeAppFiles();
        $this->makeResourcesFiles();

        return 0;
    }

    protected function replaces(): array
    {
        return [
            //
        ];
    }

    protected function makeAppFiles()
    {
        // Create directory
        $this->files->ensureDirectoryExists($this->appDir());
    }

    protected function makeResourcesFiles()
    {
        // Create view file
        $this->publishFile($this->publishesPath('views/'), resource_path());

        // Create directory
        $this->files->ensureDirectoryExists($this->resourcesDir());
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
            ['name', InputArgument::REQUIRED, 'The name of the media-manager.'],
        ];
    }
}
