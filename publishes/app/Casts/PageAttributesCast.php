<?php

namespace App\Casts;

use App\Casts\Resolvers\LinkResolver;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\ContentCast;
use Macrame\Content\Contracts\Parser;

class PageAttributesCast extends ContentCast
{
    /**
     * Parse items.
     *
     * @param  array $items
     * @return $this
     */
    public function parse()
    {
        if (! is_array($this->items)) {
            return $this;
        }

        // og image
        $og_image = File::query()
            ->where('id', $this->items['meta_og_image']['id'] ?? null)
            ->first();
        $this->items['meta_og_image_url'] = $og_image ? $og_image->getUrl() : null;

        $this->items = match ($this->model->template) {
            'default' => $this->defaultTemplate($this->items),
            'home'    => $this->homeTemplate($this->items),
            default   => $this->items
        };

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

    public function defaultTemplate(array $items)
    {
        $header = array_key_exists('header', $items) ? $items['header'] : null;
        if ($header) {
            $image = File::query()
                ->where('id', $items['header']['id'] ?? null)
                ->first();

            $image = new Image(
                $image,
                array_key_exists('alt', $header) ? $header['alt'] : '',
                array_key_exists('title', $header) ? $header['title'] : '',
            );
        }

        return [
            ...$items,
            'header' => $header ? (new ImageResource($image))->toArray(request()) : null,
        ];
    }

    public function homeTemplate(array $items)
    {
        // info section link
        $link = $this->items['info_section']['link'] ?? ['link' => ''];
        $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

        $this->items['info_section']['link'] = $link;
        $items['info_section'] = $this->items['info_section'];

        // info section image
        $info_image = File::query()
            ->where('id', $this->items['info_section']['image']['id'] ?? null)
            ->first();

        if ($info_image) {
            $items['info_section']['image'] = new Image(
                $info_image,
                $items['info_section']['image']['alt'],
                $items['info_section']['image']['title']
            );
        } else {
            $items['info_section']['image'] = null;
        }

        $items['info_section']['image'] = $items['info_section']['image']
        ? (new ImageResource($items['info_section']['image']))->toArray(request())
        : null;

        // text image link
        $link_text_image = $this->items['text_image']['link'] ?? ['link' => ''];
        $link_text_image['url'] = LinkResolver::urlFromLink($link_text_image['url'] ?? '');

        $this->items['text_image']['link'] = $link_text_image;
        $items['text_image'] = $this->items['text_image'];

        // text image image
        $text_image_image = File::query()
            ->where('id', $this->items['text_image']['image']['id'] ?? null)
            ->first();

        if ($text_image_image) {
            $items['text_image']['image'] = new Image(
                $text_image_image,
                $items['text_image']['image']['alt'],
                $items['text_image']['image']['title']
            );
        } else {
            $items['text_image']['image'] = null;
        }

        $items['text_image']['image'] = $items['text_image']['image']
        ? (new ImageResource($items['text_image']['image']))->toArray(request())
        : null;

        return [
            ...$items,
        ];
    }
}
