<?php

namespace Admin\Contracts\Media;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface AttachableFile extends File
{
    public function getFileAttachmentModel(): string;

    /**
     * Attached files relationship.
     *
     * @return MorphMany
     */
    public function file_attachments(): MorphMany;

    /**
     * Attach a file to the model.
     *
     * @param  Collection|Model $model
     * @param  mixed            $collection
     * @param  array            $attributes
     * @return void
     */
    public function attach(Collection | Model $model, ?string $collection = null, array $attriutes = []): void;

    /**
     * Detach a file from the given model('s).
     *
     * @param  Collection|Model $model
     * @return void
     */
    public function detach(Collection | Model $model): void;
}
