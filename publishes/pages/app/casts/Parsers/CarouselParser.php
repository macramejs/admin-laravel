<?php

namespace App\Casts\Parsers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Illuminate\Support\Collection;
use Macrame\Content\Contracts\Parser;

class CarouselParser implements Parser
{
    /**
     * Items.
     *
     * @var Collection
     */
    public Collection $items;

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
            if (! is_array($item)) {
                return;
            }

            $file = File::query()
                ->where('id', $item['image']['id'] ?? null)
                ->first();

            $item['image'] = new Image(
                $file,
                $item['image']['alt'],
                $item['image']['title']
            );

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
        return $this->items->map(function ($item) {
            $item['image'] = (new ImageResource($item))->toArray(request());

            return $item;
        })->toArray();
    }
}
