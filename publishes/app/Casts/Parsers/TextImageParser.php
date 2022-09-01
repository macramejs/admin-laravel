<?php

namespace App\Casts\Parsers;

use App\Casts\Resolvers\LinkResolver;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\Contracts\Parser;

class TextImageParser implements Parser
{
    /**
     * Link.
     *
     * @var array
     */
    public array $link;

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
        // image
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

        // link
        $link = $this->value['link'] ?? ['link' => ''];
        $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

        $this->link = $link;
    }

    /**
     * Get the instance as an array.
     *
     * @return array<TKey, TValue>
     */
    public function toArray()
    {
        return array_merge(
            $this->value,
            [
                'image' => $this->image
                    ? (new ImageResource($this->image))->toArray(request())
                    : null,
            ],
            [
                'link' => $this->link,
            ]
        );
    }
}
