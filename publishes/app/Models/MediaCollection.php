<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Macrame\Admin\Media\Traits\HasFiles;

class MediaCollection extends Model
{
    use HasFiles;

    protected $fillable = ['title', 'key'];
}
