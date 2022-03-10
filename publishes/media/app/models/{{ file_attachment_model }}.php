<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class {{ file_attachment_model }} extends Pivot
{
    /**
     * Database table name.
     *
     * @var string
     */
    public $table = '{{ file_attachment_table }}';

    /**
     * Indicates if the IDs are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;
}
