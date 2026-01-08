<?php

namespace Modules\Website\Services\Cart;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Session;

class CartSession
{
    const KEY = 'cart.items';

    public static function all(): Collection
    {
        return collect(Session::get(self::KEY, []));
    }

    public static function put(Collection $items): void
    {
        Session::put(self::KEY, $items->toArray());
    }

    public static function clear(): void
    {
        Session::forget(self::KEY);
    }
}
