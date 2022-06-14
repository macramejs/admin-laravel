<?php

namespace App\Models;

use App\Casts\MenuLinkCast;
use App\Models\Menu;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
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
        'parent_id', 'order_column', 'title', 'link', 'new_tab', 'type',
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        'link'    => MenuLinkCast::class,
        'type'    => MenuType::class,
        'new_tab' => 'boolean',
    ];
}
