<?php

namespace App\Models;

use Admin\Contracts\Pages\Page as PageContract;
use Admin\Traits\HasFiles;
use Admin\Traits\IsPage;
use App\Casts\ContentCast;
use App\Casts\PageAttributesCast;
use App\Casts\PageTemplateCast;
use App\Http\Controllers\PageController;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property PageTemplateCast $template
 */
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
        'is_root',
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
        'template'   => PageTemplateCast::class,
        'content'    => ContentCast::class,
        'attributes' => PageAttributesCast::class,
        'is_live'    => 'boolean',
        'is_root'    => 'boolean',
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

    public function scopeSearch($query, string $term)
    {
        $query->where('attributes', 'LIKE', "%{$term}%")
            ->orWhere('content', 'LIKE', "%{$term}%")
            ->orWhere('name', 'LIKE', "%{$term}%");
    }

    public function getTreeIds()
    {
        $parentIds = $this->parent ? $this->parent->getTreeIds() : [];

        return array_merge($parentIds, [$this->id]);
    }

    /**
     * Get the full name of the page.
     *
     * @return string
     */
    public function getFullName(): string
    {
        if (! $this->parent) {
            return $this->name;
        }

        return $this->parent->getFullName().' > '.$this->name;
    }
}
