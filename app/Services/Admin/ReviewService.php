<?php


namespace App\Services\Admin;


use App\Models\Review;

class ReviewService
{
    public function getReviews($filters = [])
    {
         $query = Review::query();

        if (!empty($filters['comment'])) {
            $query->where('comment', 'like', '%' . $filters['comment'] . '%');
        }

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', '=', $filters['created_at']);
        }

        if (!empty($filters['updated_at'])) {
            $query->whereDate('updated_at', '=', $filters['updated_at']);
        }

        return $query->paginate(10);
    }

}
