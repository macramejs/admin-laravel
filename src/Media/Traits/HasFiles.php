<?php

namespace Macrame\Admin\Media\Traits;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait HasFiles
{
    /**
     * Files relationship.
     *
     * @param string $collection
     * @param string $fileModel
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
}
