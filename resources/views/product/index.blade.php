@extends('layouts.main')
@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Shop</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">Shop</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Fruits Shop Start-->
    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            <h1 class="mb-4">Fresh products shop</h1>
            <div class="row g-4">
                <div class="col-lg-12">
                    <div class="row g-4">
                        <div class="col-xl-3">
                            <form action="{{route('product.search')}}" method="GET">
                                <div class="input-group w-100 mx-auto d-flex">
                                    <input type="search" class="form-control p-3" placeholder="Product title"
                                           aria-describedby="search-icon-1" name="search">
                                    <button type="submit" class="button" style="border: none"><i
                                            class="fa fa-search" style="color: grey"></i></button>
                                </div>
                            </form>
                        </div>
                        <div class="col-6"></div>

                    </div>
                    <div class="row g-4">
                        <div class="col-lg-3">
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="mb-3" style="margin-top: 20px">
                                        <h4>Categories</h4>
                                        <ul class="list-unstyled fruite-categorie">
                                            @foreach($categories as $category)
                                                <li>
                                                    <div class="d-flex justify-content-between fruite-name">
                                                        <a href="{{ route('product.search', ['category' =>  $category->id]) }}">
                                                            <i class="fas fa-apple-alt me-2"></i>{{ $category->name }}
                                                        </a>
                                                        <span>({{ $category->products->count() }})</span>
                                                    </div>
                                                </li>
                                            @endforeach
                                        </ul>

                                    </div>
                                </div>

                                <div class="col-lg-12">
                                    <h4 class="mb-3">Featured Products</h4>
                                    @foreach($featuredProducts as $featuredProduct)
                                        <div class="d-flex align-items-center justify-content-start">
                                            <div class="rounded me-4" style="width: 100px; height: 100px;">
                                                <img src="{{asset($featuredProduct->images->first()->image)}}"
                                                     class="img-fluid rounded" style="min-height: 70px" alt="">
                                            </div>
                                            <div>
                                                <h6 class="mb-2"><a
                                                        href="{{route('product.show',  $featuredProduct->id)}}">{{$featuredProduct->title}}</a>
                                                </h6>
                                                <div class="d-flex mb-2">
                                                    <h5 class="fw-bold me-2">${{$featuredProduct->price}}</h5>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="col-lg-12">
                                    <div class="position-relative">
                                        <img src="/img/banner-fruits.jpg" class="img-fluid w-100 rounded" alt="">
                                        <div class="position-absolute"
                                             style="top: 50%; right: 10px; transform: translateY(-50%);">
                                            <h3 class="text-secondary fw-bold">Fresh <br> Fruits <br> Banner</h3>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-9">
                            <div class="row g-4 justify-content-center">
                                @forelse($products as $product)
                                    <div class="col-md-6 col-lg-6 col-xl-4">
                                        <div class="rounded position-relative fruite-item">
                                            <div class="fruite-img">
                                                <img src="{{asset($product->images->first()->image)}}"
                                                     class="img-fluid w-100 rounded-top"
                                                     style="height: 200px" alt="">
                                            </div>
                                            <div class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                 style="top: 10px; left: 10px;">{{ $product->categories->first()->name }}</div>
                                            <div class="p-4 border border-secondary border-top-0 rounded-bottom">
                                                <h4>
                                                    <a href="{{route('product.show', $product->id)}}">{{$product->title}}</a>
                                                </h4>
                                                <p style="height: 96px">{{Str::limit($product->description, 100)}}

                                                    <div class="d-flex justify-content-between flex-lg-wrap"
                                                         style="flex-direction: column">
                                                <p class="text-dark fs-5 fw-bold mb-0">${{$product->price}} / kg</p>
                                                <div class="product-item">
                                                    <div class="input-group quantity mb-5"
                                                         style="width: 100px; margin-bottom: 1rem !important; margin-top: 10px">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                                <i class="fa fa-minus"></i>
                                                            </button>
                                                        </div>
                                                        <input type="text"
                                                               class="form-control form-control-sm text-center border-0 quantity-input"
                                                               value="1">
                                                        <div class="input-group-btn">
                                                            <button
                                                                class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                    <a href="#"
                                                       class="btn border border-secondary rounded-pill px-3 text-primary add-to-cart"
                                                       data-product-id="{{ $product->id }}">
                                                        <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                                    </a>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                            </div>
                            @empty
                                <p>No product are found.</p>
                            @endforelse
                           {{-- {{ $products->links('vendor.pagination.bootstrap-4') }}--}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- Fruits Shop End-->
@endsection
