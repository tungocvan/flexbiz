<?php

namespace Modules\Website\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use App\Models\User;

class Order extends Model
{
    protected $table = 'wp_orders'; // Khóa cứng tên bảng

    protected $fillable = [
        'user_id', 'order_code',
        'customer_name', 'customer_phone', 'customer_email', 'customer_address',
        'note',
        'subtotal', 'discount', 'total',
        'status'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
