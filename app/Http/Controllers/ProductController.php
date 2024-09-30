<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ProductService;
use App\Services\UserProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $categoryService, $productService, $userProductService;

    public function __construct(CategoryService $categoryService, ProductService $productService, UserProductService $userProductService)
    {
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->userProductService = $userProductService;
    }

    public function index()
    {
        $products = $this->productService->getProducts()/*->paginate(6)*/;
        $featuredProducts = $this->userProductService->getLatestProducts(3);
        $categories = $this->categoryService->getCategories();
        return view('product.index', compact('products', 'categories', 'featuredProducts'));
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product = Product::findorFail($id);
        $categories = $this->categoryService->getCategories();
        $allProducts = $this->productService->allProducts();
        $featuredProducts = $this->userProductService->getLatestProducts(3);
        return view('product.show', compact('product', 'categories', 'featuredProducts', 'allProducts'));
    }


    public function search(Request $request)
    {
        $searchParams = $request->all();
        $products = $this->userProductService->search($searchParams)->paginate(6);
        $featuredProducts = $this->userProductService->getProducts(3);
        $categories = $this->categoryService->getCategories();
        return view('product.index', compact('products', 'categories', 'featuredProducts'));
    }
}
