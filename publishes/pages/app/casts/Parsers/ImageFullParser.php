<?php

namespace App\Casts\Parsers;

use App\Http\Resources\MediaResource;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class ImageFullParser implements Parser
{
    /**
     * Image.
     *
     * @var File
     */
    public File $image;

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
        // image
        $this->image = File::query()
            ->where('id', $this->value['image'] ?? null)
            ->first();
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        return array_merge($this->value, [
            'image' => (new MediaResource($this->image))->toArray(request())
        ]);
    }
}
