<?php

namespace App\Models;

use App\Contracts\Restrictable;
use App\Http\Controllers\PageController;
use App\Models\Concerns\IsRestricted;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Macrame\Admin\Media\Traits\HasFiles;
use Macrame\Admin\Pages\Contracts\Page as PageContract;
use Macrame\Admin\Pages\Traits\IsPage;

class {{ model }} extends Model implements PageContract
{
    use HasFactory, HasFiles, IsPage;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'content',
        'name',
        'slug',
        'template',
        'full_slug',
        'order_column',
        'is_live',
    ];

    /**
     * Attributes casts.
     *
     * @var array
     */
    protected $casts = [
        'content'    => 'json',
        'attributes' => 'json',
        'is_live'    => 'boolean',
    ];

    protected $attributes = [
        'content'    => '[]',
        'attributes' => '[]',
    ];

    // public function addFile(File $file)
    // {
    //     $this->files()->attach($file->id);
    // }

    // public function files()
    // {

    // }
}
