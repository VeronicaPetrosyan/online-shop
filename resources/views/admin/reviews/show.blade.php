@extends('layouts.main')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Review details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.reviews.index')}}">Review</a></li>
            <li class="breadcrumb-item active text-white">Review - {{$review->id}}</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5" style="padding-bottom: 1rem !important;; padding-top:0 !important; margin-top: 0 !important; ">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">Author: {{$review->user->name}}</h4>
                            <div class="d-flex mb-3">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->star_review)
                                        <i class="fa fa-star text-secondary"></i>

                                    @else
                                        <i class="fa fa-star"></i>
                                    @endif
                                @endfor
                            </div>
                            <p class="mb-4"><b>Comment: </b>{{$review->comment}}</p>
                            <p class="mb-4"><b>Product: </b> {{$review->product->title}}</p>
                                <p class="mb-0 mt-4"><b>Created
                                        at:</b> {{ $review->created_at ? $review->created_at->format('F d, Y') : 'N/A' }}
                                </p>

                                <p class="mb-0 mt-4"><b>Updated
                                        at:</b> {{ $review->updated_at ? $review->updated_at->format('F d, Y') : 'N/A' }}
                                </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
@endsection
