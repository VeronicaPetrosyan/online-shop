@extends('layouts.main')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Products</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">Products</li>
        </ol>
    </div>

    <div class="container-fluid py-5">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Actions</th>
                    </tr>

                    <tr>
                        <form method="GET" action="{{ route('admin.products.index') }}">
                            <th></th>
                            <th>
                                <input type="text" name="title" class="form-control" value="{{ request('title') }}">
                            </th>
                            <th>
                                <input type="text" name="price" class="form-control" value="{{ request('price') }}">
                            </th>
                            <th>
                                <input type="date" name="created_at" class="form-control"
                                       value="{{ request('created_at') }}">
                            </th>
                            <th>
                                <input type="date" name="updated_at" class="form-control"
                                       value="{{ request('updated_at') }}">
                            </th>
                            <th>
                                <button type="submit" class="btn btn-primary">Filter</button>
                            </th>

                        </form>

                    </tr>
                    </thead>
                    <tbody>
                    @foreach($products as $product)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center">
                                    <img src="{{ asset($product->images->first()->image) }}"
                                         class="img-fluid me-5 rounded-circle"
                                         style="width: 80px; height: 80px;" alt="Product Image">
                                </div>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $product->title }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">${{ $product->price }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $product->created_at ? $product->created_at->format('F d, Y') : 'N/A' }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $product->updated_at ? $product->updated_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td style="display: flex; flex-direction: column; height: 97px">
                                <a href="{{ route('admin.products.edit', $product->id) }}"> Edit</a>
                                <a href="{{ route('admin.products.show', $product->id) }}"> See more</a>
                                <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                      style="display: inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="delete-btn"
                                            style="background: none; border: none; padding: 0; color: #81c408"
                                            onclick="return confirm('Are you sure?')">
                                        <i class="fa fa-times text-danger"></i> Delete
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <a href="{{route('admin.products.create')}}" class="btn border-secondary rounded-pill text-primary">Create
                    new product</a>
                {{ $products->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
