<?php

namespace App\Http\Controllers;

use App\Http\Requests\CartRequest;
use App\Services\CartService;
use Illuminate\Http\Request;


class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index()
    {
        $cartItems = $this->cartService->cartIndex();
        $totalAmount = $this->cartService->calculateCartTotal();
        return view('cart.index', compact('cartItems', 'totalAmount'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function addToCart(CartRequest $request)
    {
        return $this->cartService->addToCart($request);
    }

    public function removeFromCart($cartItemId)
    {
        $this->cartService->removeFromCart($cartItemId);
        return redirect()->back()->with('success', 'The item was removed from cart successfully.');
    }

    public function updateQuantity(Request $request, $id)
    {
        $quantity = $request->input('quantity');

        $result = $this->cartService->updateQuantity($id, $quantity);

        if ($result['success']) {
            return response()->json(['success' => true]);
        }

        return response()->json(['success' => false]);
    }
}
