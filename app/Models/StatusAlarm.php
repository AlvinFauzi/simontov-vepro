<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StatusAlarm extends Model
{
    use HasFactory;

    protected $timestamp = false;

    protected $hidden = [
        'created_at',
        'updated_at',
    ];
}
