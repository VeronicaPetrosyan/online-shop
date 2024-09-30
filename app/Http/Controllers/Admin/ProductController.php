<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSearchProductRequest;
use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ProductService;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected $productService, $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(AdminSearchProductRequest $request)
    {
        $filters = $request->only(['title', 'price', 'created_at', 'updated_at']);
        $products = $this->productService->getProducts($filters);
        $categories = $this->categoryService->getCategories();

        return view('admin.products.index', compact('products', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->categoryService->getCategories();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProductRequest $request)
    {
        $this->productService->store($request);
        return redirect()->route('admin.products.index')->with('success', 'Property created successfully');
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
        return view('admin.product.show', compact('product', 'categories'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $categories = $this->categoryService->getCategories();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */

    public function update(StoreProductRequest $request, $id)
    {
        $this->productService->update($request, $id);
        return redirect()->route('admin.products.index')
            ->with('success', 'The product has been updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->productService->deleteProduct($id);
        return back()->with('success', 'The product has been deleted successfully.');
    }

    public function search(AdminSearchProductRequest $request)
    {
        $filters = $request->all();
        $products = $this->productService->searchProducts($filters);

        return view('admin.products.index', compact('products'));
    }
}
