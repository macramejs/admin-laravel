<?php

namespace App\Models;

use App\Casts\PartialAttributesCast;
use Illuminate\Database\Eloquent\Model;
use Macrame\Admin\Media\Traits\HasFiles;

class Partial extends Model
{
    use HasFiles;

    protected $fillable = [
        'attributes',
        'name',
        'template',
    ];

    protected $casts = [
        'attributes' => PartialAttributesCast::class,
    ];

    protected $attributes = [
        'attributes' => '[]',
    ];
}
