<?php

namespace Modules\Website\Services\Cart;

use Illuminate\Support\Facades\DB;

class CartRepository
{
    public function sync(int $cartSessionId, array $items): void
    {
        DB::transaction(function () use ($cartSessionId, $items) {

            DB::table('cart_items')
                ->where('cart_session_id', $cartSessionId)
                ->delete();

            foreach ($items as $item) {
                DB::table('cart_items')->insert([
                    'cart_session_id' => $cartSessionId,
                    'product_id'      => $item['product_id'],
                    'price'           => $item['sale_price'] ?? $item['price'],
                    'qty'             => $item['qty'],
                    'created_at'      => now(),
                    'updated_at'      => now(),
                ]);
            }
        });
    }
}
