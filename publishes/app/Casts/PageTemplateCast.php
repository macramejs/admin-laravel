<?php

namespace App\Casts;

use Macrame\Content\TemplateCast;
use App\Casts\Loaders\HomeTemplateLoader;

class PageTemplateCast extends TemplateCast
{
    /**
     * Map of templates to the corresponding parsers.
     *
     * @var array
     */
    protected $parsers = [
        'home'                  => HomeTemplateLoader::class,
    ];
}
