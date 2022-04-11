<?php

namespace App\Casts;

use App\Models\File;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Macrame\Content\ContentCast;

class PageContent extends ContentCast
{
    /**
     * Parse items.
     *
     * @param array $items
     * @return $this
     */
    public function parse()
    {
        foreach ($this->items as $key => $item) {
            $this->items[$key] = $this->parseItem($item);
        }
        
        return $this;
    }

    /**
     * Parse a single item.
     *
     * @param array $item
     * @return array $item
     */
    protected function parseItem($item)
    {
        if (!array_key_exists('type', $item) || !array_key_exists('value', $item)) {
            return $item;
        }

        if (!is_array($item['value'])) {
            return $item;
        }

        $item['value'] = match ($item['type']) {
            'image' => $this->parseImageBlock($item['value']),
            default => $item['value']
        };

        return $item;
    }

    /**
     * Parse an image block.
     *
     * @param array $value
     * @return void
     */
    protected function parseImageBlock($value)
    {
        if (array_key_exists('image', $value)) {
            // dd(File::where('id', $value['image'] ?? null)->first());
            $value['image'] = File::where('id', $value['image'] ?? null)->first();
        }

        return $value;
    }
}
