<?php

namespace Macrame\Admin\Foundation\Console;

use Illuminate\Support\Str;
use Macrame\Admin\Foundation\Console\BaseMakeCommand;
use Symfony\Component\Console\Input\InputArgument;

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
    protected $publishesModule = 'nav';

    public function handle()
    {
        $this->publishModule($this->publishesModule);

        return 0;
    }
}
