<?php

namespace App\Models;

use Admin\Contracts\Media\AttachableFile;
use Admin\Traits\IsAttachableFile;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class File extends Model implements AttachableFile
{
    use IsAttachableFile;

    /**
     * Attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'display_name', 'group', 'disk', 'filepath', 'filename', 'mimetype',
        'size', 'meta',
    ];

    /**
     * Attribute casts.
     *
     * @var array
     */
    protected $casts = [
        'size' => 'int',
        'meta' => 'json',
    ];

    /**
     * Default attributes.
     *
     * @var array
     */
    protected $attributes = [
        'disk' => 'public',
    ];

    /**
     * Related collections.
     *
     * @return BelongsToMany
     */
    public function collections(): BelongsToMany
    {
        return $this->attached(MediaCollection::class);
    }

    /**
     * Gets the url to the file.
     *
     * @return string
     */
    public function getUrl()
    {
        return $this->storage()->url(
            'c/'.$this->getFilepath().DIRECTORY_SEPARATOR.$this->filename
        );
    }
}
