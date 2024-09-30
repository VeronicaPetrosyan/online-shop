@extends('layouts.main')
@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">My Orders</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">My Orders</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <div class="container-fluid fruite py-5">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif

             @if($orders->isEmpty())
                <div class="text-center">
                    <p>You have no orders yet.</p>
                </div>
            @else
                <h1 class="mb-4">Follow your Orders</h1>
                <div class="row g-4">
                    <div class="col-lg-12">
                        <div class="row g-4">
                            <div class="col-lg-9">
                                <div class="row g-4">
                                    @foreach($orders as $order)
                                        <div class="col-md-6 col-lg-6 col-xl-4" style="width: 315px;">
                                            <div class="rounded position-relative fruite-item">
                                                <div class="p-4 border border-secondary rounded-bottom" style="min-height: 270px">
                                                    <div
                                                        class="text-white bg-secondary px-3 py-1 rounded position-absolute"
                                                        style="top: 10px">
                                                        {{ $order->status}}
                                                    </div>
                                                    <div style="height: 35px">

                                                    </div>
                                                    <h4>
                                                        <a href="{{route('order.show', $order->id)}}">Order Id: {{$order->id}}</a>
                                                    </h4>
                                                    <p style="margin: 16px 0; height: 48px"><b>Products: </b>{{$order->product_names}}</p>

                                                    <div class="d-flex justify-content-between flex-lg-wrap"
                                                         style="flex-direction: column">
                                                        <p class="text-dark fs-5 fw-bold mb-0">Total Amount: ${{$order->total_amount}}</p>
                                                        <div>
                                                            <a href="{{route('order.show', $order->id)}}"
                                                               class="btn border border-secondary rounded-pill px-3 text-primary"
                                                               data-product-id="{{ $order->id }}"
                                                               style="margin-top: 10px">
                                                                <i class="fa fa-shopping-bag me-2 text-primary"></i> Check order
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection


