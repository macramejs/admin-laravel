<?php

namespace App\Casts\Parsers;

use App\Http\Resources\MediaResource;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class LogoWallParser implements Parser
{
    /**
     * items.
     *
     */
    public $items;

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
        $items = collect($this->value['items']);

        $items = $items->map(function ($item) {
            $file = File::query()
                ->where('id', $item['image']['id'] ?? null)
                ->first();
            return [
                ...$item,
                'image' => [
                    ...$item['image'],
                    ...($file ? (new MediaResource($file))->toArray(request()): [])
                ]
            ];
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
            'items' => $this->items
        ]);
    }
}
