<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminSearchCategoryRequest;
use App\Http\Requests\StoreCategoryRequest;
use App\Models\Category;
use App\Services\Admin\CategoryService;
use App\Services\Admin\ProductService;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected $productService;
    protected $categoryService;

    public function __construct(ProductService $productService, CategoryService $categoryService)
    {
        $this->productService = $productService;
        $this->categoryService = $categoryService;
    }

    public function index(AdminSearchCategoryRequest $request)
    {
        $filters = $request->only(['name', 'created_at', 'updated_at']);
        $categories = $this->categoryService->getCategories($filters);

        return view('admin.categories.index', compact('categories'));
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        $this->categoryService->addCategory($request->name);
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category created successfully');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $category = Category::findOrFail($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(StoreCategoryRequest $request, $id)
    {
        $this->categoryService->updateCategory($request->name, $id);
        return redirect()->route('admin.categories.index')
            ->with('success', 'Category has been updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->categoryService->deleteCategory($id);
        return back()->with('success', 'Category has been deleted successfully.');
    }
}
