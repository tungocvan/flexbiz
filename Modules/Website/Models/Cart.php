<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cart extends Model
{
    protected $fillable = ['session_id', 'user_id'];

    public function items(): HasMany
    {
        return $this->hasMany(CartItem::class, 'cart_id'); //
    }
}
