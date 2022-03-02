<?php

namespace Macrame\CMS\Media\Contracts;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;

interface AttachableFile extends File
{
    public function getFileAttachmentModel(): string;

    public function file_attachments(): MorphMany;

    public function attach(Collection | Model $model, ?string $collection = null, array $attriutes = []);
}
