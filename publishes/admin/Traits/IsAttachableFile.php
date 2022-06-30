<?php

namespace Admin\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

trait IsAttachableFile
{
    use IsFile;

    /**
     * Boot the IsAttachableFile trait.
     *
     * @return void
     */
    public static function bootIsAttachableFile(): void
    {
        self::deleting(function ($file) {
            $file->file_attachments()->delete();
        });
    }

    /**
     * Gets the file attachmend model.
     *
     * @return string
     */
    public function getFileAttachmentModel(): string
    {
        if (property_exists($this, 'fileAttachmentModel')) {
            return $this->filfeAttachmentModel;
        }

        return \App\Models\FileAttachment::class;
    }

    /**
     * Gets the file attachment table name.
     *
     * @return string
     */
    public function getFileAttachmentTable(): string
    {
        $fileAttachmentModel = $this->getFileAttachmentModel();

        return (new $fileAttachmentModel)->getTable();
    }

    /**
     * Attached files relationship.
     *
     * @return MorphMany
     */
    public function file_attachments(): MorphMany
    {
        return $this->morphMany($this->getFileAttachmentModel(), 'file');
    }

    /**
     * File attachments relationship.
     *
     * @param  string        $model
     * @return BelongsToMany
     */
    public function attached(string $model): BelongsToMany
    {
        return $this
            ->belongsToMany(
                $model,
                $this->getFileAttachmentTable(),
                'file_id',
                'model_id',
            )
            ->using($this->getFileAttachmentModel())
            ->wherePivot('model_type', $model)
            ->wherePivot('file_type', static::class);
    }

    /**
     * Attach a file to the model.
     *
     * @param  Collection|Model $model
     * @param  mixed            $collection
     * @param  array            $attributes
     * @return void
     */
    public function attach(Collection | Model $model, $collection = null, $attributes = []): void
    {
        if ($model instanceof Collection) {
            $model->each(fn (Model $m) => $this->attach($m, $collection, $attributes));

            return;
        }

        $this->file_attachments()
            ->create(array_merge($attributes, [
                'model_type' => get_class($model),
                'model_id'   => $model->getKey(),
                'collection' => $collection,
            ]));
    }

    /**
     * Detach a file from the given model('s).
     *
     * @param  Collection|Model $model
     * @return void
     */
    public function detach(Collection | Model $model): void
    {
        if ($model instanceof Collection) {
            $model->each(fn (Model $m) => $this->detach($m));

            return;
        }

        $this->file_attachments()
            ->where([
                'model_type' => get_class($model),
                'model_id'   => $model->getKey(),
            ])
            ->delete();
    }
}
