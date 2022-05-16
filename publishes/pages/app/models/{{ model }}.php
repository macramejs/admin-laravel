<?php

namespace App\Models;

use App\Http\Controllers\PageController;
use App\Casts\PageAttributes;
use App\Casts\PageContent;
use App\Contracts\Restrictable;
use App\Models\Concerns\IsRestricted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Macrame\Admin\Media\Traits\HasFiles;
use Macrame\Admin\Pages\Contracts\Page as PageContract;
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
        'meta_title',
        'meta_description',
    ];

    /**
     * Attributes casts.
     *
     * @var array
     */
    protected $casts = [
        'content'    => PageContent::class,
        'attributes' => PageAttributes::class,
        'is_live'    => 'boolean',
    ];

    /**
     * Default model attributes.
     *
     * @var array
     */
    protected $attributes = [
        'content'    => '[]',
        'attributes' => '[]',
        'is_live'    => true
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
}
