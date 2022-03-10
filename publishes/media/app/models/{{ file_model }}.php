<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Macrame\Admin\Media\Contracts\AttachableFile;
use Macrame\Admin\Media\Traits\IsAttachableFile;

class {{ file_model }} extends Model implements AttachableFile
{
    use IsAttachableFile;

    protected $fillable = [
        'display_name', 'group', 'disk', 'filepath', 'filename', 'mimetype',
        'size', 'meta',
    ];

    protected $casts = [
        'size' => 'int',
        'meta' => 'json',
    ];

    protected $attributes = [
        'disk' => 'public',
    ];

    public function collections(): BelongsToMany
    {
        return $this->attached({{ page }}Collection::class);
    }
}
