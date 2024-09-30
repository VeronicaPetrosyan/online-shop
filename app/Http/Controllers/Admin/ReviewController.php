<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSearchReviewRequest;
use App\Models\Review;
use App\Services\Admin\ReviewService;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $reviewService;

    public function __construct(ReviewService $reviewService)
    {
        $this->reviewService = $reviewService;
    }

   public function index(AdminSearchReviewRequest $request)
    {
        $filters = $request->only(['comment', 'created_at', 'updated_at']);
        $reviews = $this->reviewService->getReviews($filters);
        return view('admin.reviews.index', compact('reviews'));
    }


    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $review = Review::findOrFail($id);
        return view('admin.reviews.show', compact('review'));
    }

    public function search(AdminSearchReviewRequest $request)
    {
        $filters = $request->all();
        $reviews = $this->reviewService->searchReviews($filters);

        return view('admin.reviews.index', compact('reviews'));
    }
}
