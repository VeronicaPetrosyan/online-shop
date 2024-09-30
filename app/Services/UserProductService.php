<?php


namespace App\Services;


use App\Models\Product;

class UserProductService
{
    public function search($searchParams)
    {
        $query = Product::query();
        if (!empty($searchParams['search'])) {
            $query->where('title', 'like', "%{$searchParams['search']}%");
        }

        if (!empty($searchParams['category'])) {
            $query->whereHas('categories', function ($query) use ($searchParams) {
                $query->where('category_id', $searchParams['category']);
            });
        }
        return $query;
    }

    public function getLatestProducts($limit)
    {
        return Product::latest()->take($limit)->get();
    }

}
