<?php

namespace Macrame\CMS\Pages\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Macrame\Contracts\Tree\Tree;

interface Page extends Tree
{
    /**
     * Build the routes.
     *
     * @return void
     */
    public static function routes();

    /**
     * Gets the route action for the page.
     *
     * @return string|Closure
     */
    public function getRouteAction(): string | Closure;

    /**
     * Gets the full slug of the page.
     *
     * @return string
     */
    public function getFullSlug(): string;

    public function parent(): BelongsTo;

    public function children(): HasMany;
}
