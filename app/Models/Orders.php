<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Orders
 * @package App\Models
 */
class Orders extends Model
{
    protected $fillable = [
        'id',
        'status',
        'city',
        'waybill',
        'postal_office',
        'sms_waybill_status',
        'comment',
        'client_id',
        'created_at',
        'updated_at',
        'modified_by',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    /**
     * Relation with Clients.
     *
     * @return BelongsTo
     */
    public function client(): BelongsTo
    {
        return $this->belongsTo(Clients::class,'client_id');
    }

    /**
     * Relation with OrderItems.
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\OrderItems', 'order_id');
    }
}
