<?php

namespace Macrame\Admin\Pages\Contracts;

use Closure;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Macrame\Contracts\Tree\Tree;

interface Page extends Tree
{
    /**
     * Build the routes.
     *
     * @param  string $controller
     * @return void
     */
    public static function routes($controller);

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

    /**
     * Parent relationship.
     *
     * @return BelongsTo
     */
    public function parent(): BelongsTo;

    /**
     * Children relationship.
     *
     * @return HasMany
     */
    public function children(): HasMany;
}
