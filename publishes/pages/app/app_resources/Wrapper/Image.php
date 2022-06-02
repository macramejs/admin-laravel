<?php

namespace App\Http\Resources\Wrapper;

use App\Models\File;

class Image
{
    public function __construct(
        public File $file,
        public $alt,
        public $title,
    ) {
        //
    }
}
