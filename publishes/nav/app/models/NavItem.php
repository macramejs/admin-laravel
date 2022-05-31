<?php

namespace App\Models;

use Admin\Http\Resources\Models\RouteItem;
use App\Casts\NavRoute;
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
        'route'   => NavRoute::class,
        'type'    => NavType::class,
        'new_tab' => 'boolean',
    ];

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
