<?php

namespace App\Casts\Parsers;

use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class ImageFullParser implements Parser
{
    /**
     * Image.
     *
     * @var Image
     */
    public ?Image $image;

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
        $file = File::query()
            ->where('id', $this->value['image']['id'] ?? null)
            ->first();

        if ($file) {
            $this->image = new Image(
                $file,
                $this->value['image']['alt'],
                $this->value['image']['title']
            );
        } else {
            $this->image = null;
        }
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        return array_merge($this->value, [
            'image' => $this->image
                ? (new ImageResource($this->image))->toArray(request())
                : null,
        ]);
    }
}
