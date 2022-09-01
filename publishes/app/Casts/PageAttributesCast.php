<?php

namespace App\Casts;

use App\Casts\Resolvers\LinkResolver;
use App\Http\Resources\ImageResource;
use App\Http\Resources\Wrapper\Image;
use App\Models\File;
use Macrame\Content\ContentCast;

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

        $this->items = match ($this->model->template) {
            'default'     => $this->defaultTemplate($this->items),
            'home'        => $this->homeTemplate($this->items),
            default       => $this->items
        };

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

        // services link
        $link_services = $this->items['services']['link'] ?? ['link' => ''];
        $link_services['url'] = LinkResolver::urlFromLink($link_services['url'] ?? '');

        $this->items['services']['link'] = $link_services;
        $items['services'] = $this->items['services'];

        // services cards links
        $items['services']['items'] = collect($items['services']['items'] ?? [])->map(function ($item) {
            if (! is_array($item)) {
                return;
            }

            $link = $item['link'] ?? ['link' => ''];
            $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

            $box = collect([
                'title' => $item['title'],
                'icon'  => $item['icon'],
                'link'  => $link,
            ]);

            return $box;
        })->filter();

        // quickstart links
        $items['teaser_boxes']['items'] = collect($items['teaser_boxes']['items'] ?? [])->map(function ($item) {
            if (! is_array($item)) {
                return;
            }

            $link = $item['link'] ?? ['link' => ''];
            $link['url'] = LinkResolver::urlFromLink($link['url'] ?? '');

            $box = collect([
                'title' => $item['title'],
                'link'  => $link,
            ]);

            return $box;
        })->filter();

        return [
            ...$items,
        ];
    }
}
