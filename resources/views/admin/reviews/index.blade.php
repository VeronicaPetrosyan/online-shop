@extends('layouts.main')
@section('content')

    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Reviews</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item active text-white">Reviews</li>
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
                        <th scope="col">Review</th>
                        <th scope="col">Created at</th>
                        <th scope="col">Updated at</th>
                        <th scope="col">Actions</th>
                    </tr>

                    <form method="GET" action="{{ route('admin.reviews.index') }}">
                        <th>
                            <input type="text" name="comment" class="form-control" value="{{ request('comment') }}">
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
                    </thead>
                    <tbody>
                    @foreach($reviews as $review)
                        <tr>
                            <td>
                                <p class="mb-0 mt-4">{{ Str::limit($review->comment, 25) }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $review->created_at ? $review->created_at->format('F d, Y') : 'N/A' }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $review->updated_at ? $review->updated_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td style="display: flex; flex-direction: column; height: 97px">
                                <a href="{{ route('admin.reviews.show', $review->id) }}" style="margin: 10px 0"> See
                                    more</a>
                                <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST"
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
                {{ $reviews->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
