<?php

namespace App\Models;

use App\Models\Bookkeeping\Providers;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\MorphToMany;


/**
 * Class Products
 * @package App\Models
 *
 * @property ProductsPhoto $productsPhoto
 * @property Providers $providers
 * @property Clients $clients
 * @property Reviews $reviews
 * @property Orders $orders
 */
class Products extends Model
{
    protected $fillable = [
        'id',
        'status',
        'title',
        'description',
        'h1',
        'content',
        'characteristics',
        'size_table',
        'price',
        'sale_price',
        'published',
        'discount_price',
        'preview',
        'images',
        'category_id',
        'total_sales',
    ];

    protected $casts = [
        'title' => 'array',
        'h1' => 'array',
        'description' => 'array',
        'content' => 'array',
        'characteristics' => 'array',
    ];

    /**
     * Relations with photo.
     *
     * @return HasMany
     */
    public function images(): HasMany
    {
        return $this->hasMany('App\Models\ProductsPhoto', 'product_id', 'id');
    }

    /**
     * Relation with providers.
     *
     * @return BelongsTo
     */
    public function Providers()
    {
        return $this->belongsTo(Providers::class, 'provider_id');
    }

    /**
     * Relations with colors.
     *
     * @return BelongsToMany
     */
    public function colors(): BelongsToMany
    {
        return $this->belongsToMany(Colors::class, 'product_color', 'product_id', 'color_id');
    }

    /**
     * Relations with Client.
     *
     * @return HasMany
     */
    public function Client()
    {
        return $this->hasMany(Clients::class,);
    }

    /**
     * Relations with Reviews
     *
     * @return HasMany
     */
    public function Reviews()
    {
        return $this->hasMany(Reviews::class, 'product_id');
    }

    /**
     * Relations with Order
     *
     * @return HasOne
     */
    public function Order()
    {
        return $this->hasOne(Orders::class, 'product_id');
    }

    /**
     * Polymorphic relation with categories
     *
     * @return MorphToMany
     */
    public function categories()
    {
        return $this->morphToMany('App\Models\Categories', 'categoryables');
    }
}
