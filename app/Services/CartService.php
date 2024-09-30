<?php

namespace App\Services;

use App\Http\Requests\CartRequest;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cookie;

class CartService
{
    public function addToCart(CartRequest $request)
    {
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity', 1);

        if (Auth::check()) {
            $this->addToCartDatabase(Auth::id(), $productId, $quantity);
        } else {
            $this->addToCartCookie($productId, $quantity);
        }

        return response()->json(['message' => 'The product has been added to cart.']);

    }

    private function addToCartDatabase($userId, $productId, $quantity)
    {
        $cartItem = CartItem::where('user_id', $userId)
            ->where('product_id', $productId)
            ->first();

        if ($cartItem) {
            $cartItem->quantity += $quantity;
        } else {
            $cartItem = new CartItem();
            $cartItem->user_id = $userId;
            $cartItem->product_id = $productId;
            $cartItem->quantity = $quantity;
        }

        $cartItem->save();
    }

    private function addToCartCookie($productId, $quantity)
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $found = false;

        foreach ($cart as &$item) {
            if ($item['product_id'] == $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        if (!$found) {
            $cart[] = ['product_id' => $productId, 'quantity' => $quantity];
        }

        Cookie::queue('cart', json_encode($cart));
    }

    public function cartIndex()
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $cartItems = CartItem::where('user_id', $user_id)->get();
        } else {
            $cartItems = $this->getCartItemsFromCookie();
        }

        return $cartItems;
    }

    private function getCartItemsFromCookie()
    {
        $cart = json_decode(Cookie::get('cart', '[]'), true);
        $cartItems = [];

        foreach ($cart as $item) {
            $product = Product::find($item['product_id']);
            if ($product) {
                $cartItems[] = (object)[
                    'id' => $item['product_id'],
                    'product' => $product,
                    'quantity' => $item['quantity']
                ];
            }
        }

        return collect($cartItems);
    }

    public function calculateCartTotal()
    {
        $user_id = Auth::id();
        $cartItems = CartItem::where('user_id', $user_id)->get();
        $totalAmount = 0;

        foreach ($cartItems as $cartItem) {
            $product = Product::find($cartItem->product_id);
            if ($product) {
                $totalAmount += $product->price * $cartItem->quantity;
            }
        }

        return $totalAmount;
    }

    public function removeFromCart($cartItemId)
    {
        if (Auth::check()) {
            $user_id = Auth::id();
            $cartItem = CartItem::where('user_id', $user_id)
                ->where('id', $cartItemId)
                ->first();

            if ($cartItem) {
                $cartItem->delete();
            }
        } else {
            $cart = json_decode(Cookie::get('cart', '[]'), true);
            foreach ($cart as $key => $item) {
                if ($item['product_id'] == $cartItemId) {
                    unset($cart[$key]);
                    break;
                }
            }
            $cart = array_values($cart);
            Cookie::queue('cart', json_encode($cart));
        }

        return redirect()->back()->with('success', 'Cart item removed successfully');
    }


    public function updateQuantity($id, $quantity)
    {
        if (Auth::check()) {
            $cartItem = CartItem::where('id', $id)
                ->where('user_id', Auth::id())
                ->first();

            if ($cartItem) {
                $cartItem->quantity = $quantity;
                $cartItem->save();

                return ['success' => true];
            }
        } else {
            $cart = json_decode(Cookie::get('cart', '[]'), true);
            foreach ($cart as &$item) {
                if ($item['product_id'] == $id) {
                    $item['quantity'] = $quantity;
                    break;
                }
            }
            Cookie::queue('cart', json_encode($cart));

            return ['success' => true];
        }

        return ['success' => false];
    }

    public static function getCartData()
    {
        if (Auth::check()) {
            $cartItems = CartItem::where('user_id', Auth::id())->get();
            $cartCount = $cartItems->sum('quantity');
        } else {
            $cart = json_decode(Cookie::get('cart', '[]'), true);
            $cartCount = array_sum(array_column($cart, 'quantity'));
        }

        return ['cartCount' => $cartCount];
    }
}
