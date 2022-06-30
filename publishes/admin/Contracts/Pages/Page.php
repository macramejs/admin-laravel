<?php

namespace Admin\Contracts\Pages;

use Closure;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Http\Request;
use Illuminate\Routing\Route;
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
     * Get the page model from the given request.
     *
     * @param  Request $request
     * @return self
     */
    public static function fromRequestOrFail(Request $request);

    /**
     * Get the associated route.
     *
     * @return Route
     */
    public function getRoute(): Route;

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
