@extends('layouts.main')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop Detail</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="#">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.products.index')}}">Products</a></li>
            <li class="breadcrumb-item active text-white">Product - {{$product->title}}</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div id="productCarousel" class="carousel slide" data-ride="carousel">
                                <div class="carousel-inner">
                                    @foreach ($product->images as $key => $image)
                                        <div class="carousel-item {{ $key == 0 ? 'active' : '' }}">
                                            <img src="{{ asset($image->image) }}" class="d-block w-100 img-fluid rounded" alt="Image">
                                        </div>
                                    @endforeach
                                </div>
                                <a class="carousel-control-prev" href="#productCarousel" role="button" data-slide="prev">
                                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Previous</span>
                                </a>
                                <a class="carousel-control-next" href="#productCarousel" role="button" data-slide="next">
                                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                                    <span class="sr-only">Next</span>
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{$product->title}}</h4>
                            <p class="mb-3">Category:
                                @foreach ($product->categories as $category)
                                    <span>{{ $category->name }}</span>
                                    @if (!$loop->last)
                                        ,
                                    @endif
                                @endforeach
                            </p>
                            <h5 class="fw-bold mb-3">${{$product->price}}</h5>
                            <p class="mb-4">{{$product->description}}</p>
                            <div style="display: flex; flex-direction: row">
                                <p class="mb-0 mt-4"><b>Created
                                        at:</b> {{ $product->created_at ? $product->created_at->format('F d, Y') : 'N/A' }}
                                </p>
                                <span style="margin: 0 8px"></span>
                                <p class="mb-0 mt-4"><b>Updated
                                        at:</b> {{ $product->updated_at ? $product->updated_at->format('F d, Y') : 'N/A' }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
@endsection
