<?php

namespace Admin\Http\Resources\Models;

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
        public string $url,
        public string $title
    ) {
        //
    }

    /**
     * Create new RouteItem instance from laravel route name and parameters.
     *
     * @param string $title
     * @param string $name
     * @param array $parameters
     * @return RouteItem
     */
    public static function fromRoute($title, $name, $parameters = [])
    {
        $url = "route://{$name}";

        if (!empty($parameters)) {
            $url .= "?".http_build_query($parameters);
        }

        return new RouteItem($url, $title);
    }
}
