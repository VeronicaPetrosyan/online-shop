<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreReviewRequest;
use App\Services\UserReviewService;


class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $reviewService;

    public function __construct(UserReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

    public function store(StoreReviewRequest $request, $productId)
    {
        $this->reviewService->storeReview($request, $productId);
        return redirect()->back()->with('success', 'Review submitted successfully!');
    }
}
