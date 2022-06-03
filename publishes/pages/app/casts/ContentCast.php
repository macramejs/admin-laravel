<?php

namespace App\Casts;

use Macrame\Content\ContentCast as BaseContentCast;

class ContentCast extends BaseContentCast
{
    /**
     * List of parsers.
     *
     * @var array
     */
    protected $parsers = [
        'image_full' => Parsers\ImageFullParser::class,
        'text_image' => Parsers\ImageFullParser::class,
        'logo_wall'  => Parsers\LogoWallParser::class,
        'carousel'   => Parsers\CarouselParser::class,
        'info_box'   => Parsers\InfoBoxParser::class,
        'cards'      => Parsers\CardsParser::class,
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
     * @param  array $item
     * @return array $item
     */
    protected function parseItem($item)
    {
        if (! array_key_exists('type', $item) || ! array_key_exists('value', $item)) {
            return $item;
        }

        if (! is_array($item['value'])) {
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
     * @param array       $value
     * @param string|null $parser
     * @param bool        $toArray
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
