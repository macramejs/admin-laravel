<?php

namespace Macrame\CMS\Media\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;
use Macrame\CMS\Media\Contracts\AttachableFile;

trait HasFiles
{
    public function files($collection = null, $fileModel = null): BelongsToMany
    {
        if (is_null($fileModel)) {
            $fileModel = $this->getFileModel();
        }

        return $this
            ->belongsToMany(
                $fileModel,
                $this->getFileAttachmentTable(),
                'model_id',
                'file_id'
            )
            ->using($this->getFileAttachmentModel())
            ->wherePivot('file_type', $fileModel)
            ->wherePivot('model_type', static::class);
    }

    public function attachFile(AttachableFile $file, ?string $collection = null, array $attributes = [])
    {
        $file->attach($this, $collection, $attributes);
    }

    public function attachFiles(Collection $files, ?string $collection = null, array $attributes = [])
    {
        foreach ($files as $file) {
            $this->attachFile($file, $collection, $attributes);
        }
    }

    public function getFileModel(): string
    {
        if (property_exists($this, 'fileModel')) {
            return $this->fileModel;
        }

        return \App\Models\File::class;
    }

    /**
     * Gets the file attachmend model.
     *
     * @return string
     */
    public function getFileAttachmentModel(): string
    {
        if (property_exists($this, 'fileAttachmentModel')) {
            return $this->fileAttachmentModel;
        }

        return \App\Models\FileAttachment::class;
    }

    public function getFileAttachmentTable(): string
    {
        $fileAttachmentModel = $this->getFileAttachmentModel();

        return (new $fileAttachmentModel)->getTable();
    }
}
