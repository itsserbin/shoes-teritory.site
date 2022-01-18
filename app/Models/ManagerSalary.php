<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManagerSalary extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'date',
        'manager_id',
    ];
}
