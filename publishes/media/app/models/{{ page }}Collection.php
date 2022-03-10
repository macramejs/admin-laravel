<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Macrame\CMS\Media\Traits\HasFiles;

class {{ page }}Collection extends Model
{
    use HasFiles;

    protected $fillable = ['title', 'key'];
}
