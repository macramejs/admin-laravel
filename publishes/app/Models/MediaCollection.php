<?php

namespace App\Models;

use Admin\Traits\HasFiles;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaCollection extends Model
{
    use HasFiles, HasFactory;

    protected $fillable = ['title', 'key'];

    protected $table = 'file_collections';
}
