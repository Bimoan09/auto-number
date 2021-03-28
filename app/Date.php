<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Date extends Model
{
    protected $table ='date_table';

    protected $fillable =
    [
        'date',
        'serial_number',
    ];
}
