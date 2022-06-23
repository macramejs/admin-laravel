<?php

namespace App\Models;

use App\Casts\ContentCast;
use App\Casts\PageAttributesCast;
use App\Http\Controllers\PageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Macrame\Admin\Contracts\Pages\Page as PageContract;
use Macrame\Admin\Media\Traits\HasFiles;
use Macrame\Admin\Pages\Traits\IsPage;

class Page extends Model implements PageContract
{
    use HasFactory, HasFiles, IsPage;

    /**
     * The route controller.
     *
     * @var string
     */
    protected $controller = PageController::class;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'attributes',
        'name',
        'slug',
        'template',
        'full_slug',
        'order_column',
        'is_live',
        'parent_id',
        'publish_at',
        'meta_title',
        'meta_description',
        'preview_key',
    ];

    /**
     * Attributes casts.
     *
     * @var array
     */
    protected $casts = [
        'content'    => ContentCast::class,
        'attributes' => PageAttributesCast::class,
        'is_live'    => 'boolean',
        'publish_at' => 'datetime',
    ];

    /**
     * Default model attributes.
     *
     * @var array
     */
    protected $attributes = [
        'content'    => '[]',
        'attributes' => '[]',
        'is_live'    => false,
    ];

    /**
     * Attributes that should be appended.
     *
     * @var array
     */
    protected $appends = [
        'has_been_published',
    ];

    /**
     * The creator of the page.
     *
     * @return BelongsTo
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    /**
     * Has been published attribute.
     *
     * @return bool
     */
    public function getHasBeenPublishedAttribute()
    {
        return $this->publish_at < now();
    }
}
