<?php

namespace App\Casts\Parsers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class LogoWallParser implements Parser
{
    /**
     * items.
     */
    public $items;

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
        $items = collect($this->value['items'])->map(function ($item) {
            $file = File::query()
                ->where('id', $item['image']['id'] ?? null)
                ->first();

            $item['image'] = new Image(
                $file,
                $item['image']['alt'],
                $item['image']['title']
            );

            return $item;
        });

        $this->items = $items;
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
                $item['image'] = (new ImageResource($item['image']))->toArray(request());

                return $item;
            }),
        ]);
    }
}
