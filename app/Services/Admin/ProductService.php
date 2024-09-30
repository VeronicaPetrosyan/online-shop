<?php


namespace App\Services\Admin;


use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Spatie\Permission\Exceptions\UnauthorizedException;
use Whoops\Handler\PrettyPageHandler;

class ProductService
{
    public function getProducts($filters = [])
    {
        $query = Product::query();

        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        if (!empty($filters['price'])) {
            $query->where('price', '=', $filters['price']);
        }

        if (!empty($filters['created_at'])) {
            $query->whereDate('created_at', '=', $filters['created_at']);
        }

        if (!empty($filters['updated_at'])) {
            $query->whereDate('updated_at', '=', $filters['updated_at']);
        }

        return $query->paginate(10);
    }

    public function allProducts()
    {
        return Product::all();
    }

    public function store($request)
    {
        if (!auth()->user()->can('manage products')) {
            throw UnauthorizedException::forPermissions(['manage products']);
        }

        $product = new Product();
        $product->fill($request->all());

        $product->save();

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->move(public_path('img'), $imageName);
                $product->images()->create(['image' => 'img/' . $imageName]);
            }
        }
        $product->categories()->attach($request->input('categories'));
    }

    public function update(StoreProductRequest $request, $id)
    {
        $product = Product::findOrFail($id);
        $product->fill($request->all());
        $product->save();

        $product->categories()->sync($request->input('categories', []));

        if ($request->hasFile('images')) {
            foreach ($product->images as $image) {
                $imagePath = public_path($image->image);
                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
                $image->delete();
            }

            foreach ($request->file('images') as $image) {
                $imageName = time() . '_' . $image->getClientOriginalName();
                $imagePath = $image->move(public_path('img'), $imageName);
                $product->images()->create(['image' => 'img/' . $imageName]);
            }
        }
    }


    public function deleteProduct($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();
    }

}
