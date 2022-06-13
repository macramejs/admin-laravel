<?php

namespace App\Casts\Resolvers;

use Symfony\Component\Routing\Exception\RouteNotFoundException;

class LinkResolver
{
    /**
     * Resolve url from the given link.
     *
     * @param  string $link
     * @return void
     */
    public static function urlFromLink(string $link)
    {
        $parsed = parse_url($link);

        if (! $parsed || ($parsed['scheme'] ?? '') != 'route') {
            return $link;
        }

        $name = $parsed['host'] ?? '';
        parse_str($parsed['query'] ?? '', $parameters);

        try {
            return route($name, $parameters);
        } catch (RouteNotFoundException $e) {
            //
        }

        return $link;
    }
}
