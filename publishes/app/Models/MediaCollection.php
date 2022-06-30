<?php

namespace App\Models;

use Admin\Traits\HasFiles;
use Illuminate\Database\Eloquent\Model;

class MediaCollection extends Model
{
    use HasFiles;

    protected $fillable = ['title', 'key'];
}
