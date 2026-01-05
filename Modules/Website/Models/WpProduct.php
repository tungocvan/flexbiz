<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class WpProduct extends Model
{
    protected $table = 'wp_products';

    protected $fillable = [
        'title', 'slug', 'short_description', 'description',
        'regular_price', 'sale_price', 'image', 'gallery', 'tags', 'is_active'
    ];

    protected $casts = [
        'gallery' => 'array', //
        'tags' => 'array',    //
        'is_active' => 'boolean',
        'regular_price' => 'decimal:2',
        'sale_price' => 'decimal:2',
    ];

    // Accessors
    public function getFinalPriceAttribute(): float
    {
        return (float) ($this->sale_price > 0 && $this->sale_price < $this->regular_price
            ? $this->sale_price
            : $this->regular_price);
    }

    public function getDiscountPercentAttribute(): int
    {
        if ($this->regular_price > 0 && $this->sale_price > 0) {
            return (int) round((($this->regular_price - $this->sale_price) / $this->regular_price) * 100);
        }
        return 0;
    }

    // Relationships
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'category_product', 'product_id', 'category_id');
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }
}
