<?php

namespace Admin\Traits;

use Admin\Contracts\Media\AttachableFile;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Collection;

trait HasFiles
{
    /**
     * Files relationship.
     *
     * @param  string        $collection
     * @param  string        $fileModel
     * @return BelongsToMany
     */
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

    /**
     * Determines whether the model is attached to the given file.
     *
     * @param  AttachableFile $file
     * @return bool
     */
    public function isAttachedTo(AttachableFile $file)
    {
        return (bool) $this->files->where('id', $file->id)->first();
    }

    /**
     * Attach a file to the model.
     *
     * @param  AttachableFile $file
     * @param  string|null    $collection
     * @param  array          $attributes
     * @return void
     */
    public function attachFile(AttachableFile $file, ?string $collection = null, array $attributes = [])
    {
        $file->attach($this, $collection, $attributes);
    }

    /**
     * Detach a file from the model.
     *
     * @param  AttachableFile $file
     * @return void
     */
    public function detachFile(AttachableFile $file)
    {
        $file->detach($this);
    }

    /**
     * Attach a collection of files to the model.
     *
     * @param  Collection  $files
     * @param  string|null $collection
     * @param  array       $attributes
     * @return void
     */
    public function attachFiles(Collection $files, ?string $collection = null, array $attributes = [])
    {
        foreach ($files as $file) {
            $this->attachFile($file, $collection, $attributes);
        }
    }

    /**
     * Gets the name of the file model.
     *
     * @return string
     */
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

    /**
     * Getes the name of the file attachmenet table.
     *
     * @return string
     */
    public function getFileAttachmentTable(): string
    {
        $fileAttachmentModel = $this->getFileAttachmentModel();

        return (new $fileAttachmentModel)->getTable();
    }
}
