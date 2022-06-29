<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class FileAttachment extends Pivot
{
    /**
     * Database table name.
     *
     * @var string
     */
    public $table = 'file_attachments';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
