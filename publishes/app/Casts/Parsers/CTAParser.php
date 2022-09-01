<?php

namespace App\Casts\Parsers;

use App\Casts\Resolvers\LinkResolver;
use Macrame\Content\Contracts\Parser;

class CTAParser implements Parser
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
        $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

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
}
