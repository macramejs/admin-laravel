<?php

namespace App\Models;

use {{ namespace }}\Http\Resources\Models\RouteItem;
use App\Models\Types\NavType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;
use Macrame\Contracts\Tree\Tree;
use Macrame\Tree\Traits\IsTree;

class NavItem extends Model implements Tree
{
    use HasFactory, IsTree;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'parent_id', 'order_column', 'title', 'route', 'new_tab', 'type',
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        'type'    => NavType::class,
        'new_tab' => 'boolean',
    ];

    /**
     * Get a list of the selectable routes for the nav item.
     *
     * @param  NavType          $type
     * @return array|Collection
     */
    public static function routeItems(NavType $type)
    {
        $items = Page::get()->map(function (Page $page) {
            return new RouteItem($page->getRoute()->getName(), $page->name);
        });

        return $items;
    }

    /**
     * Determines whether the route is an url.
     *
     * @return bool
     */
    public function isRouteUrl()
    {
        return preg_match('#^https?://.+#', $this->route);
    }
}
