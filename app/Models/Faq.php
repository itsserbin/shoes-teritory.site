<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    protected $casts = [
        'answer' => 'array',
        'question' => 'array',
    ];
}
