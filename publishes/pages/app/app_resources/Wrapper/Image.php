<?php

namespace App\Http\Resources\Wrapper;

use App\Models\File;

class Image
{
    public function __construct(
        public File $image,
        public $alt,
        public $title,
    ) {
        //
    }
}
