<?php

namespace App\Casts;

use App\Models\File;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Jsonable;
use Macrame\Content\ContentCast;

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

        $this->items = $this->items = match ($this->model->template) {
            // ...
            default => $this->items
        };
        
        return $this;
    }
}
