<?php

namespace App\Helpers;

use App\Models\CartItem;
use Illuminate\Support\Arr;

class Cart
{
    public static function getCartItemsCount(): int
    {
        $request = \request();
        $user = $request->user();
        if ($user) {
            return CartItem::where('user_id', $user->id)->sum('quantity');
        } else {
            $cartItems = json_decode($request->cookie('cart_items', '[]'), true);

            return array_reduce(
                $cartItems,
                fn ($carry, $item) => $carry + $item['quantity'],
                0
            );
        }
    }

    public static function getCartItems()
    {
        $request = \request();
        $user = $request->user();

        if ($user) {
            // $cartItems = [];
            // foreach (CartItem::where('user_id', $user->id)->get() as $item) {
            //     $cartItems[] = ['product_id' => $item->product_id, 'quantity' => $item->quantity];
            // }
            // return $cartItems;
            return CartItem::where('user_id', $user->id)->get()->map(
                fn ($item) => ['product_id' => $item->product_id, 'quantity' => $item->quantity]
            );
        } else {
            return json_decode($request->cookie('cart_items', '[]'), true);
        }
    }

    public static function getCountFromItems($cartItems)
    {
        return array_reduce(
            $cartItems,
            fn ($carry, $item) => $carry + $item['quantity'],
            0
        );
    }

    public static function getCountAndTotalFromItems($cartItems)
    {
        return array_reduce(
            $cartItems,
            function ($carry, $item) {
                return [
                    'count' => $carry['count'] + $item['quantity'],
                    'total' => $carry['total'] + ($item['quantity'] * $item['price'])
                ];
            },
            ['count' => 0, 'total' => 0]
        );
    }
}