<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Class CartItems
 * @package App\Models
 *
 * @property int $id
 * @property int $cart_id
 * @property int $product_id
 * @property int $count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property Cart $cart
 * @property Products $products
 */
class CartItems extends Model
{
    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'cart_items';

    /**
     * Using timestamp
     *
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = [
        'hash',
        'cart_id',
        'product_id',
        'provider_id',
        'color',
        'size',
        'pay',
        'count',
        'created_at',
        'updated_at'
    ];

    protected $casts = [
        'color' => 'array',
        'size' => 'array',
    ];

    /**
     * Relation with cart.
     *
     * @return HasOne
     */
    public function cart(): HasOne
    {
        return $this->hasOne(Cart::class, 'id', 'cart_id');
    }

    /**
     * Relation with product.
     *
     * @return HasOne
     */
    public function product(): HasOne
    {
        return $this->hasOne(Products::class, 'id', 'product_id');
    }
}
