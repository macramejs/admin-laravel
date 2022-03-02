<?php

namespace Macrame\CMS\Media\Contracts;

use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface File
{
    public static function newFromUploadedFile(UploadedFile $file, array $attributes = []);

    public function getDiskName();

    public function getFilepath(): ?string;

    public function storage(): Filesystem;
}
