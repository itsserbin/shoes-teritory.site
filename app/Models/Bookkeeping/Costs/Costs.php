<?php

namespace App\Models\Bookkeeping\Costs;

use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Costs extends Model
{
    protected $fillable = [
        'name',
        'quantity',
        'sum',
        'total',
        'user_id',
        'comment',
        'date',
        'cost_category_id',
    ];

    protected $dates = [
        'date',
        'created_at',
        'updated_at',
    ];

    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function category(): HasOne
    {
        return $this->hasOne(CostCategory::class, 'id', 'cost_category_id');
    }
}
