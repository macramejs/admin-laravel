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

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a Macrame Admin navigation builder.';

    /**
     * The module that is being published.
     *
     * @var string
     */
    protected $publishesModule = 'nav';

    public function handle()
    {
        $this->publishModule($this->publishesModule);

        return 0;
    }
}
