<?php


namespace App\Services;

use App\Http\Requests\StoreOrderRequest;
use App\Models\CartItem;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;


class OrderService
{
    public function makeOrder(StoreOrderRequest $request)
    {
        $order = new Order();
        $order->fill($request->all());
        $order->user_id = Auth::id();

        $totalAmount = $this->calculateOrderTotalAmount($request->checkoutItems);
        $order->total_amount = $totalAmount;

        $order->save();

        foreach ($request->checkoutItems as $checkoutItem) {
            $orderItem = new OrderItem([
                'order_id' => $order->id,
                'product_id' => $checkoutItem['product_id'],
                'quantity' => $checkoutItem['quantity'],
                'price' => $checkoutItem['price'],
            ]);
            $orderItem->save();
        }

        CartItem::where('user_id', Auth::id())->delete();
    }

    private function calculateOrderTotalAmount($checkoutItems)
    {
        $totalAmount = 0;
        foreach ($checkoutItems as $item) {
            $totalAmount += $item['quantity'] * $item['price'];
        }
        return $totalAmount;
    }

    public function displayOrders()
    {
        $user = Auth::user();
        $orders = $user->orders()->get();

        foreach ($orders as $order) {
            $order->product_names = $this->getProductNames($order);
        }

        return $orders;
    }

    public function getProductNames($order, $limit = 3)
    {
        $productNames = collect($order->orderItems)->take($limit)->pluck('product.title')->implode(', ');

        if ($order->orderItems->count() > $limit) {
            $productNames .= ' ...';
        }

        return $productNames;
    }

    public function getAllOrders()
    {
        $user = Auth::user();
        $orders = $user->orders()->get()->paginate(10);

        foreach ($orders as $order) {
            $order->product_names = $this->getProductNames($order);
        }

        return $orders;
    }


}
