<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'type', 'title',
    ];

    /**
     * Default attributes.
     *
     * @var array
     */
    protected $attributes = [
        //
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        //
    ];

    /**
     * The associated menu items.
     *
     * @return HasMany
     */
    public function items(): HasMany
    {
        return $this->hasMany(MenuItem::class, 'menu_id', 'id');
    }
}
