<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Advantages extends Model
{
    protected $casts = [
        'text' => 'array',
    ];
}
