<?php

namespace App\Models;

use App\Casts\MenuLinkCast;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Macrame\Contracts\Tree\Tree;
use Macrame\Tree\Traits\IsTree;

class MenuItem extends Model implements Tree
{
    use HasFactory, IsTree;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id',
        'order_column',
        'title',
        'link',
        'new_tab',
        'menu_id',
        'is_group',
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        'link'               => MenuLinkCast::class,
        'new_tab'            => 'boolean',
        'is_group'           => 'boolean',
    ];

    /**
     * The corresponding menu.
     *
     * @return HasOne
     */
    public function menu(): HasOne
    {
        return $this->hasOne(Menu::class);
    }

    /**
     * Determines whether the item is public.
     *
     * @return bool
     */
    public function isPublic()
    {
        $parsed = parse_url($this->link);

        if (! $parsed || ($parsed['scheme'] ?? '') != 'route') {
            return true;
        }

        $page = Page::find(explode('site.', $this->link)[1]);

        if ($page->is_live) {
            if (is_null($page->publish_at) || $page->publish_at < now()) {
                return true;
            }
        }

        return false;
    }
}
