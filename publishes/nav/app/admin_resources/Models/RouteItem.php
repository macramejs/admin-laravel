<?php

namespace {{ namespace }}\Http\Resources\Models;

class RouteItem
{
    /**
     * Create new RouteItem instance.
     *
     * @param string $name
     * @param string $title
     * @return void
     */
    public function __construct(
        public string $name,
        public string $title
    ) {
        //
    }
}
