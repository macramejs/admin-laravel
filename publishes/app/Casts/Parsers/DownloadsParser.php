<?php

namespace App\Casts\Parsers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class DownloadsParser implements Parser
{
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
            if (array_key_exists('file', $item)) {
                $file = File::query()
                    ->where('id', $item['file']['id'] ?? null)
                    ->first();

                if ($file) {
                    $item['file'] = new Image(
                        $file,
                        $item['file']['alt'],
                        $item['file']['title']
                    );
                } else {
                    $item['file'] = null;
                }
            }

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
                $item['file'] = $item['file'] ? (new ImageResource($item['file']))->toArray(request()) : null;

                return $item;
            }),
        ]);
    }
}
