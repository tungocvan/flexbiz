<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = [
        'name', 'slug', 'url', 'icon', 'can', 'type', 'parent_id',
        'description', 'image', 'is_active', 'sort_order', 'meta_title', 'meta_description'
    ];

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Category::class, 'parent_id')->orderBy('sort_order', 'asc');
    }

    public function childrenRecursive(): HasMany
    {
        return $this->children()->with('childrenRecursive');
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(WpProduct::class, 'category_product', 'category_id', 'product_id');
    }

    // Scopes
    public function scopeActive(Builder $query): void
    {
        $query->where('is_active', true);
    }

    public function scopeOfType(Builder $query, string $type): void
    {
        $query->where('type', $type);
    }

    public function scopeRoot(Builder $query): void
    {
        $query->whereNull('parent_id');
    }

    // Helper
    public function getAllChildrenIds(): array
    {
        $ids = [$this->id];
        foreach ($this->children as $child) {
            $ids = array_merge($ids, $child->getAllChildrenIds());
        }
        return $ids;
    }
}
