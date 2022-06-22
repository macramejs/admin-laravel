<?php

namespace Admin\Http\Resources\Options;

class LinkOption
{
    /**
     * Create new Link instance.
     *
     * @param  string $link
     * @param  string $title
     * @return void
     */
    public function __construct(
        public string $link,
        public string $title
    ) {
        //
        // http://example.com
        // route://site.1?name=foo
    }

    /**
     * Create new RouteItem instance from laravel route name and parameters.
     *
     * @param  string $title
     * @param  string $name
     * @param  array  $parameters
     * @return static
     */
    public static function fromRoute($title, $name, $parameters = [])
    {
        $link = "route://{$name}";

        if (! empty($parameters)) {
            $link .= '?'.http_build_query($parameters);
        }

        return new static($link, $title);
    }
}
