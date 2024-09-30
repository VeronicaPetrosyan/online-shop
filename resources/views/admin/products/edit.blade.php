@extends('layouts.main')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Edit Product</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{ url('/') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{ route('admin.products.index') }}">Products</a></li>
            <li class="breadcrumb-item active text-white">Edit - {{ $product->title }}</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Edit</h1>
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="row g-5">
                    <div class="col-md-12 col-lg-6 col-xl-7">
                        <div class="row">
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3"><b>Product Title</b></label>
                                    <input type="text" class="form-control" name="title" value="{{ $product->title }}">
                                </div>
                            </div>
                            <div class="col-md-12 col-lg-6">
                                <div class="form-item w-100">
                                    <label class="form-label my-3"><b>Product Price</b></label>
                                    <input type="text" class="form-control" name="price" value="{{ $product->price }}">
                                </div>
                            </div>
                        </div>
                        <div class="form-item" style="display: flex; flex-direction: column;">
                            <label class="form-label my-3"><b>Product Images</b></label>
                            <input type="file" name="images[]" accept="image/*" multiple>
                        </div>
                        <div class="form-item" style="display: flex; flex-direction: column;">
                            <label class="form-label my-3"><b>Product Description</b></label>
                            <textarea name="description" id="" cols="30" rows="10" style="border: 1px solid #ced4da;">{{ $product->description }}</textarea>
                        </div>
                        <div class="form-item" style="display: flex; flex-direction: column;">
                            <label class="form-label my-3"><b>Product Category</b></label>
                            <select class="form-control" name="categories[]" multiple required>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ $product->categories->contains($category->id) ? 'selected' : '' }}>{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="row g-4 text-center align-items-center pt-4" style="width: 200px">
                            <button type="submit" style="margin-left: 10px" class="btn border-secondary text-uppercase text-primary">Submit</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endsection
