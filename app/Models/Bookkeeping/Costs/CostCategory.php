<?php

namespace App\Models\Bookkeeping\Costs;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class CostCategory extends Model
{
    public function cost(): HasMany
    {
        return $this->hasMany(Costs::class, 'cost_category_id', 'id');
    }
}
