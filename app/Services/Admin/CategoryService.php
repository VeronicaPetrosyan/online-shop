<?php


namespace App\Services\Admin;

use App\Models\Category;

class CategoryService
{
    public function getCategories($filters = [])
    {
        $query = Category::with('products');

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', '=', $filters['created_at']);
        }

        if (!empty($filters['updated_at'])) {
            $query->whereDate('updated_at', '=', $filters['updated_at']);
        }

        return $query->paginate(10);
    }


    public function addCategory($name)
    {
        $category = new Category();
        $category->name = $name;
        $category->save();
    }

    public function updateCategory($name, $id)
    {
        $category = Category::findOrFail($id);
        $category->name = $name;
        $category->save();
    }

    public function deleteCategory($id)
    {
        $category = Category::findOrFail($id);
        $category->delete();
    }

    /*    public function searchCategories($filters = [])
        {
            $query = Category::query();

            if (!empty($filters['name'])) {
                $query->where('name', 'like', '%' . $filters['name'] . '%');
            }

            if (!empty($filters['created_at'])) {
                $query->whereDate('created_at', '=', $filters['created_at']);
            }

            if (!empty($filters['updated_at'])) {
                $query->whereDate('updated_at', '=', $filters['updated_at']);
            }

            return $query->paginate(10);
        }*/


}
