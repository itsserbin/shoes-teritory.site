<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $casts = [
        'heading' => 'array',
        'h1' => 'array',
        'content' => 'array',
        'meta_title' => 'array',
        'meta_description' => 'array',
    ];
}
