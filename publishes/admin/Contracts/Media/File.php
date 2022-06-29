<?php

namespace Admin\Contracts\Media;

use Illuminate\Contracts\Filesystem\Filesystem;
use Symfony\Component\HttpFoundation\File\UploadedFile;

interface File
{
    /**
     * Create a new file model from the uploaded file.
     *
     * @param  UploadedFile $file
     * @param  array        $attributes
     * @return static
     */
    public static function createFromUploadedFile(UploadedFile $file, array $attributes = []): static;

    /**
     * Gets the url to the file.
     *
     * @return string
     */
    public function getUrl();

    /**
     * Get the disk name of the file model.
     *
     * @return void
     */
    public function getDiskName();

    /**
     * Get the file path of the model.
     *
     * @return string|null
     */
    public function getFilepath(): ?string;

    /**
     * Gets hhe filesystem for the model.
     *
     * @return FilesystemAdapter
     */
    public function storage(): Filesystem;
}
