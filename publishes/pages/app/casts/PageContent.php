<?php

namespace App\Casts;

use App\Models\File;
use Macrame\Content\ContentCast;
use App\Casts\Parsers\LogoWallParser;
use Illuminate\Contracts\Support\Jsonable;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

class PageContent extends ContentCast
{
    /**
     * List of parsers.
     *
     * @var array
     */
    protected $parsers = [
        'image_full' => Parsers\ImageFullParser::class,
        'text_image' => Parsers\ImageFullParser::class,
        'logo_wall' => Parsers\LogoWallParser::class,
        'carousel' => Parsers\CarouselParser::class,
        'info_box' => Parsers\InfoBoxParser::class,
    ];

    /**
     * Parse items.
     *
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

        $item['value'] = $this->parseItemValue(
            $item['value'],
            $this->parsers[$item['type']] ?? null,
        );

        return $item;
    }

    /**
     * Parse item value.
     *
     * @param array $value
     * @param string|null $parser
     * @param boolean $toArray
     * @return
     */
    protected function parseItemValue(array $value, ?string $parser)
    {
        if (is_null($parser)) {
            return $value;
        }

        $p = new $parser($value);
        $p->parse();

        return $p;
    }
}
