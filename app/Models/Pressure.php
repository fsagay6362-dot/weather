<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pressure extends Model
{
    protected $table = 'pressures';

    protected $fillable = [
        'pressure',
        'recorded_at',
    ];

    public $timestamps = false;
}
