<?php

namespace App\Casts;

use App\Models\File;
use Macrame\Content\ContentCast;
use App\Http\Resources\MediaResource;

class PageAttributes extends ContentCast
{
    /**
     * Parse items.
     *
     * @param array $items
     * @return $this
     */
    public function parse()
    {
        if (!is_array($this->items)) {
            return $this;
        }

        $this->items = match ($this->model->template) {
            'default' => $this->defaultTemplate($this->items),
            default => $this->items
        };
        
        return $this;
    }

    public function defaultTemplate(array $items)
    {
        $header = File::query()
            ->where('id', $items['header']['id'] ?? null)
            ->first();

        return [
            ...$items,
            'header' => $header ? (new MediaResource($header))->toArray(request()) : null
        ];
    }
}
