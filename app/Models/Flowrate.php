<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Flowrate extends Model
{
    use HasFactory, SoftDeletes, Loggable;

    protected $fillable = [
        'mag_date',
        'flowrate',
        'unit_flowrate',
        'totalizer_1',
        'totalizer_2',
        'totalizer_3',
        'unittotalizer',
        'analog_1',
        'analog_2',
        'status_battery',
        'alarm',
        'bin_alarm',
        'file_name',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'mag_date' => 'datetime',
    ];

    public function getBin()
    {
        return strrev($this->bin_alarm);
    }
}
