<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_code', 'customer_name', 'customer_phone',
        'customer_email', 'customer_address', 'note', 'subtotal',
        'discount', 'total', 'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class, 'order_id'); //
    }
}
