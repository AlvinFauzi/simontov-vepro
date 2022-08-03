<?php

namespace App\Models;

use Haruncpi\LaravelUserActivity\Traits\Loggable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory, Loggable;

    protected $hidden = [
        'created_at',
        'updated_at'
    ];
}
