<?php


namespace App\Services;


use App\Models\Review;

class UserReviewService
{
    public function storeReview($request, $productId)
    {
        $review = new Review();
        $review->fill($request->all());
        $review->user_id = auth()->id();
        $review->product_id = $productId;
        $review->save();
    }
}
