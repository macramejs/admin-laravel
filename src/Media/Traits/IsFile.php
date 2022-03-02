<?php

namespace Macrame\CMS\Media\Traits;

use Illuminate\Contracts\Filesystem\Filesystem;
use Illuminate\Filesystem\FilesystemAdapter;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;

trait IsFile
{
    protected ?File $file;

    /**
     * Boot the IsAttachableFile trait.
     *
     * @return void
     */
    public static function bootIsFile(): void
    {
        self::saved(function (self $file) {
            $file->setFilepath($file->id);

            $file->storeFileOnDisk();

            if ($file->isDirty('filepath')) {
                $file->save();
            }
        });
    }

    public function storeFileOnDisk()
    {
        if (! isset($this->file)) {
            return;
        }

        $this->storage()->putFileAs(
            $this->getFilepath(),
            $this->file,
            $this->filename
        );
    }

    public function setFile(File $file)
    {
        $this->file = $file;
    }

    public function unsetFile(): void
    {
        unset($this->file);
    }

    public function getFile(): ?File
    {
        return $this->file;
    }

    public static function newFromUploadedFile(UploadedFile $file, array $attributes = [])
    {
        $model = new static([
            'filepath' => Str::uuid(),
            'filename' => $file->getClientOriginalName(),
            'mimetype' => $file->getClientMimeType(),
            'size'     => $file->getSize(),
        ]);

        $model->setFile($file);

        return $model;
    }

    public function getUrl()
    {
        return $this->storage()->url(
            $this->getFilepath().DIRECTORY_SEPARATOR.$this->filename
        );
    }

    /**
     * The filesystem that should be used.
     *
     * @return FilesystemAdapter
     */
    public function storage(): FilesystemAdapter
    {
        return Storage::disk($this->getDiskName());
    }

    public function getDiskName(): string
    {
        return $this->disk;
    }

    public function setFilepath(string $path)
    {
        $this->filepath = $path;
    }

    public function getFilepath(): ?string
    {
        return $this->filepath;
    }
}
