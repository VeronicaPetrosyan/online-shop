@extends('layouts.main')
@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Product Details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('product.index')}}">Products</a></li>
            <li class="breadcrumb-item active text-white">{{$product->title}} Details</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Single Product Start -->
    <div class="container-fluid py-5 mt-5">
        <div class="container py-5">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="row g-4 mb-5">
                <div class="col-lg-8 col-xl-9">
                    <div class="row g-4">
                        <div class="col-lg-6">
                            <div class="border rounded">
                                <a href="#">
                                    <img src="{{asset($product->images->first()->image)}}" class="img-fluid rounded"
                                         alt="Image">
                                </a>
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <h4 class="fw-bold mb-3">{{$product->title}}</h4>
                            <p class="mb-3">Category:
                                @foreach ($product->categories as $productCategory)
                                    <span>{{ $productCategory->name }}</span>
                                    @if (!$loop->last), @endif
                                @endforeach
                            </p>
                            <h5 class="fw-bold mb-3">${{$product->price}}</h5>
                            <p class="mb-4">{{$product->description}}</p>
                            <div class="product-item">
                                <div class="input-group quantity mb-5" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text"
                                           class="form-control form-control-sm text-center border-0 quantity-input"
                                           value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-plus rounded-circle bg-light border">
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
                        <div class="col-lg-12">
                            <nav>
                                <div class="nav nav-tabs mb-3">
                                    <button class="nav-link active border-white border-bottom-0" type="button"
                                            role="tab"
                                            id="nav-about-tab" data-bs-toggle="tab" data-bs-target="#nav-about"
                                            aria-controls="nav-about" aria-selected="true">Description
                                    </button>
                                    <button class="nav-link border-white border-bottom-0" type="button" role="tab"
                                            id="nav-mission-tab" data-bs-toggle="tab" data-bs-target="#nav-mission"
                                            aria-controls="nav-mission" aria-selected="false">Reviews
                                    </button>
                                </div>
                            </nav>
                            <div class="tab-content mb-5">
                                <div class="tab-pane active" id="nav-about" role="tabpanel"
                                     aria-labelledby="nav-about-tab">
                                    <p>{{$product->description}}</p>
                                </div>

                                <div class="tab-pane" id="nav-mission" role="tabpanel"
                                     aria-labelledby="nav-mission-tab">
                                    @forelse($product->reviews as $review)
                                        <div class="d-flex">
                                            <img src="/img/avatar.jpg" class="img-fluid rounded-circle p-3"
                                                 style="width: 100px; height: 100px;" alt="">
                                            <div>
                                                <p class="mb-2"
                                                   style="font-size: 14px;">{{ $review->created_at->format('F j, Y') }}</p>
                                                <div class="d-flex justify-content-between" style="width: 600px">
                                                    <h5>{{$review->user->name}}</h5>
                                                    <div class="d-flex mb-3">
                                                        @for ($i = 1; $i <= 5; $i++)
                                                            @if ($i <= $review->star_review)
                                                                <i class="fa fa-star text-secondary"></i>

                                                            @else
                                                                <i class="fa fa-star"></i>
                                                            @endif
                                                        @endfor
                                                    </div>
                                                </div>
                                                <p>{{$review->comment}}</p>

                                            </div>
                                        </div>
                                    @empty
                                        <p style="padding-left: 15px">No reviews found.</p>
                                    @endforelse
                                </div>

                            </div>


                        </div>
                        <form action="{{ route('review.store', $product->id) }}" method="POST">
                            @csrf
                            <h4 class="mb-5 fw-bold" style="margin-bottom: 0 !important;">Leave a Review</h4>
                            <div class="row g-4">
                                <div class="col-lg-12">
                                    <div class="star-rating d-flex">
                                        @for($i = 1; $i <= 5; $i++)
                                            <input type="radio" id="star{{$i}}" name="star_review" value="{{$i}}"
                                                   required>
                                            <label for="star{{$i}}">&#9733;</label>
                                        @endfor

                                    </div>
                                </div>
                                <div class="col-lg-12" style="margin-top: 0">
                                    <div class="border-bottom rounded my-4">
                                            <textarea name="comment" class="form-control border-0" cols="30" rows="8"
                                                      placeholder="Write here" spellcheck="false" required></textarea>
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <button type="submit"
                                            class="btn border border-secondary rounded-pill px-4 py-2 mb-4 text-primary">
                                        Submit
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-4 col-xl-3">
                    <div class="row g-4">
                        <div class="col-lg-12">
                            <form action="{{route('product.search')}}" method="GET">
                                <div class="input-group mb-4">
                                    <input type="search" class="form-control p-3" placeholder="Product title"
                                           aria-describedby="search-icon-1" name="search">
                                    <button type="submit" class="button" style="border: none"><i
                                            class="fa fa-search" style="color: grey"></i></button>
                                </div>
                            </form>
                            <div class="mb-4">
                                <h4>Categories</h4>
                                <ul class="list-unstyled fruite-categorie">
                                    @foreach($categories as $category)
                                        <li>
                                            <div class="d-flex justify-content-between fruite-name">
                                                <a href="{{route('category.products', $category->id) }}}}">{{$category->name}}</a>
                                                <span>({{$category->products->count()}})</span>
                                            </div>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="col-lg-12">
                            <h4 class="mb-4">Featured products</h4>
                            @foreach($featuredProducts as $featuredProduct)
                                <div class="d-flex align-items-center justify-content-start">
                                    <div class="rounded" style="width: 100px; height: 100px; margin-right: 15px">
                                        <img src="{{asset($featuredProduct->images->first()->image)}}"
                                             class="img-fluid rounded" alt="Image">
                                    </div>
                                    <div>
                                        <h6 class="mb-2"><a
                                                href="{{route('product.show', $featuredProduct->id)}}">{{$featuredProduct->title}}</a>
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
            </div>
            <h1 class="fw-bold mb-0">Related products</h1>
            <div class="vesitable">
                <div class="owl-carousel vegetable-carousel justify-content-center">
                    @foreach($allProducts as $item)
                        <div class="border border-primary rounded position-relative vesitable-item">
                            <div class="vesitable-img">
                                <a href="{{route('product.show', $item->id)}}"><img
                                        src="/{{$item->images->first()->image}}" class="img-fluid w-100 rounded-top"
                                        style="height: 200px" alt=""></a>
                            </div>
                            <div class="text-white bg-primary px-3 py-1 rounded position-absolute"
                                 style="top: 10px; right: 10px;">{{$item->categories->first()->name}}</div>
                            <div class="p-4 pb-0 rounded-bottom">
                                <p>{{Str::limit($item->description, 35)}}</p>
                                <div class="d-flex justify-content-between flex-lg-wrap">
                                    <p class="text-dark fs-5 fw-bold">${{$item->price}} / kg</p>
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
                                           data-product-id="{{ $product->id }}" style="margin-bottom: 15px !important;">
                                            <i class="fa fa-shopping-bag me-2 text-primary"></i> Add to cart
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- Single Product End -->
    <style>
        .star-rating {
            display: inline-flex;
        }

        .star-rating input[type="radio"] {
            display: none;
        }

        .star-rating label {
            font-size: 2rem;
            color: #ddd;
            cursor: pointer;
            transition: color 0.2s;
        }

        .star-rating input[type="radio"]:checked ~ label {
            color: #ffc107;
        }

        .star-rating label:hover,
        .star-rating label:hover ~ label {
            color: #ffc107;
        }
    </style>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const stars = document.querySelectorAll('.star-rating label');
            const radioButtons = document.querySelectorAll('.star-rating input[type="radio"]');

            function highlightStars(starIndex) {
                stars.forEach((star, index) => {
                    if (index <= starIndex) {
                        star.style.color = '#ffc107';
                    } else {
                        star.style.color = '#ddd';
                    }
                });
            }

            stars.forEach((star, index) => {
                star.addEventListener('click', function () {
                    const ratingValue = this.previousElementSibling.value;
                    radioButtons.forEach((radio, radioIndex) => {
                        radio.checked = (radio.value <= ratingValue);
                    });
                    highlightStars(index);
                });

                star.addEventListener('mouseover', function () {
                    highlightStars(index);
                });

                star.addEventListener('mouseout', function () {
                    const checkedRadio = document.querySelector('.star-rating input[type="radio"]:checked');
                    if (checkedRadio) {
                        const checkedIndex = Array.from(radioButtons).indexOf(checkedRadio);
                        highlightStars(checkedIndex);
                    } else {
                        highlightStars(-1);
                    }
                });
            });
        });
    </script>


@endsection
