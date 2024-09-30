@extends('layouts.main')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Categories</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">Categories</li>
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
                    <tr style="border:none !important;">
                        <th scope="col">Category</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Actions</th>
                    </tr>
                    <tr>
                        <form method="GET" action="{{ route('admin.categories.index') }}">

                            <th>
                                <input type="text" name="name" class="form-control" value="{{ request('name') }}">
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
                    @foreach($categories as $category)
                        <tr>
                            <td>
                                <p class="mb-0 mt-4">{{ $category->name }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $category->created_at ? $category->created_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $category->updated_at ? $category->updated_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td style="display: flex; flex-direction: column; height: 97px">
                                <a href="{{ route('admin.categories.edit', $category->id) }}" style="margin: 10px 0">
                                    Edit</a>
                                <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST"
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
                <a href="{{route('admin.categories.create')}}" class="btn border-secondary rounded-pill text-primary">Create
                    new category</a>
                {{ $categories->appends(request()->query())->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
