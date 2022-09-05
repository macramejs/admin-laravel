<?php

namespace App\Casts;

use App\Casts\Resolvers\LinkResolver;
use Macrame\Content\ContentCast as BaseContentCast;
use Macrame\Content\Contracts\Parser;

class ContentCast extends BaseContentCast
{
    /**
     * List of parsers.
     *
     * @var array
     */
    protected $parsers = [
        'block'          => Parsers\BlockParser::class,
        'image_small'    => Parsers\ImageFullParser::class,
        'image_full'     => Parsers\ImageFullParser::class,
        'text_image'     => Parsers\TextImageParser::class,
        'info_section'   => Parsers\TextImageParser::class,
        'logo_wall'      => Parsers\LogoWallParser::class,
        'image_carousel' => Parsers\CarouselParser::class,
        'teaser_boxes'   => Parsers\TeaserBoxesParser::class,
        'cta'            => Parsers\CTAParser::class,
        'map'            => Parsers\MapParser::class,
        'info_box'       => Parsers\InfoBoxParser::class,
        'cards'          => Parsers\CardsParser::class,
        'downloads'      => Parsers\DownloadsParser::class,
        'grid_gallery'   => Parsers\GridGalleryParser::class,
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

        // For any item, we want to make sure routes are replaced with actual links
        array_walk_recursive($this->items, function (&$value, $key) {
            if ($value instanceof Parser || $key == 'items') {
                return;
            }

            $value = preg_replace_callback('/"(route:\/\/.*?)"/', function ($match) {
                return '"'.LinkResolver::urlFromLink($match[1]).'"';
            }, $value);
        });

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
