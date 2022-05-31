<?php

namespace App\Casts\Parsers;

use App\Models\File;
use Illuminate\Support\Collection;
use App\Http\Resources\MediaResource;
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
     * Create new Repeatable instance.
     *
     * @param array $value
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
            if (!is_array($item)) {
                return;
            }

            $item['image'] = File::query()
                ->where('id', $item['image'] ?? null)
                ->first();

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
            $item['image'] = (new MediaResource($item))->toArray(request());

            return $item;
        })->toArray();
    }
}
