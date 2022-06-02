<?php

namespace App\Casts\Parsers;

use App\Casts\Resolvers\LinkResolver;
use Macrame\Content\Contracts\Parser;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class InfoBoxParser implements Parser
{
    /**
     * Link.
     *
     * @var array
     */
    public array $link;

    /**
     * Create new Parser instance.
     *
     * @param  array $value
     * @return void
     */
    public function __construct(
        protected array $value
    ) {
        //
    }

    public function parse()
    {
        $link = $this->value['link'] ?? ['link' => ''];
        $link['link'] = LinkResolver::urlFromLink($link['link'] ?? '');

        $this->link = $link;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        return array_merge($this->value, [
            'link' => $this->link,
        ]);
    }

    /**
     * Get the url representation of the link.
     *
     * @return string
     */
    public function url($link)
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
