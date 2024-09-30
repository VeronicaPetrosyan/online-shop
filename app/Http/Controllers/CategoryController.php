<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Services\Admin\CategoryService;
use App\Services\UserProductService;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $categoryService, $userProductService;

    public function __construct(CategoryService $categoryService, UserProductService $userProductService)
    {
        $this->categoryService = $categoryService;
        $this->userProductService = $userProductService;
    }

    public function showProducts(Category $category)
    {
        $products = $category->products()->paginate(2);
        $categories = $this->categoryService->getCategories();
        $featuredProducts = $this->userProductService->getLatestProducts(3);
        return view('product.index', compact('products', 'categories', 'featuredProducts'));
    }
}
