<?php

namespace App\Casts\Parsers;

use App\Casts\Resolvers\LinkResolver;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class CardsParser implements Parser
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
        // items
        $this->items = collect($this->value['items'] ?? [])->map(function ($item) {
            if (array_key_exists('image', $item)) {
                $file = File::query()
                    ->where('id', $item['image']['id'] ?? null)
                    ->first();

                if ($file) {
                    $item['image'] = new Image(
                        $file,
                        $item['image']['alt'],
                        $item['image']['title']
                    );
                } else {
                    $item['image'] = null;
                }
            }

            $link = $item['link'] ?? ['link' => ''];
            $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

            $item['link'] = $link;

            return $item;
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
            'items' => $this->items->map(function ($item) {
                $item['image'] = $item['image'] ? (new ImageResource($item['image']))->toArray(request()) : null;

                return $item;
            }),
        ]);
    }
}
