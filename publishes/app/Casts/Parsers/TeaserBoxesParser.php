<?php

namespace App\Casts\Parsers;

use App\Casts\Resolvers\LinkResolver;
use Macrame\Content\Contracts\Parser;

class TeaserBoxesParser implements Parser
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
        $this->items = collect($this->value['items'] ?? [])->map(function ($item) {
            if (! is_array($item)) {
                return;
            }

            $link = $item['link'] ?? ['link' => ''];
            $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

            $box = collect([
                'title' => $item['title'],
                'link'  => $link,
            ]);

            return $box;
        })->filter();
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        return array_merge($this->value, [
            'items' => $this->items,
        ]);
    }
}
