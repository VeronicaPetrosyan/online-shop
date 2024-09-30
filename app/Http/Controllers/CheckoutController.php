<?php

namespace App\Http\Controllers;

use App\Services\CartService;
use Illuminate\Http\Request;

class CheckoutController extends Controller
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
        $checkoutItems = $this->cartService->cartIndex();
        $totalAmount = $this->cartService->calculateCartTotal();
        return view('checkout.index', compact('checkoutItems', 'totalAmount'));
    }

}
