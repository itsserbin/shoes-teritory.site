<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Cart
 * @package App\Models
 *
 * @property int $id
 * @property string $hash
 * @property int $user_id
 * @property string $created_at
 * @property string $updated_at
 *
 * @property CartItems $items
 *
 */
class Cart extends Model
{
    /**
     * Database table name
     *
     * @var string
     */
    protected $table = 'cart';

    /**
     * Using timestamp
     *
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = ['hash', 'user_id', 'created_at', 'updated_at'];

    /**
     * Relation with items.
     *
     * @return HasMany
     */
    public function items()
    {
        return $this->hasMany('App\Models\CartItems', 'cart_id', 'id')->with('product');
    }
}
