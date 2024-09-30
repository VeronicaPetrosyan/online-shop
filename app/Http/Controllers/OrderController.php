<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreOrderRequest;
use App\Models\Order;
use App\Models\User;
use App\Services\CartService;
use App\Services\OrderService;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $orderService, $cartService;

    public function __construct(OrderService $orderService, CartService $cartService)
    {
        $this->orderService = $orderService;
        $this->cartService = $cartService;
    }

    public function index()
    {
        $orders = $this->orderService->displayOrders();
        return view('order.index', compact('orders'));
    }

    public function store(StoreOrderRequest $request)
    {
        $this->orderService->makeOrder($request);
        return redirect()
            ->route('product.index')
            ->with('success', 'Order has been placed successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /* @var User $user */
        $user = Auth::user();
        $order = $user->orders()->findOrFail($id);
        return view('order.show', compact('order'));
    }
}
