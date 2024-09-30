@extends('layouts.main')
@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Order Details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('order.index')}}">My Orders</a></li>
            <li class="breadcrumb-item active text-white">Order Id: {{$order->id}}</li>
        </ol>
    </div>
    <!-- Single Page Header End -->


    <!-- Order Details Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            @if (session('success'))
                <div class="alert alert-success">
                    <p>{{ session('success') }}</p>
                </div>
            @endif
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Products</th>
                        <th scope="col">Name</th>
                        <th scope="col">Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($order->orderItems as $orderItem)
                        <tr>
                            <th scope="row">
                                <div class="d-flex align-items-center" style="width: 80px; min-height: 80px;">
                                    <img src="{{ asset($orderItem->product->images->first()->image) }}"
                                         class="img-fluid me-5 rounded-circle"
                                         alt="">
                                </div>
                            </th>
                            <td>
                                <p class="mb-0 mt-4">{{ $orderItem->product->title }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">${{ $orderItem->product->price }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $orderItem->quantity }}</p>
                            </td>
                            <td class="item-total">
                                <p class="mb-0 mt-4">${{ $orderItem->quantity * $orderItem->product->price }}</p>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
                <p style="text-align: right"><b>Total Amount: </b>{{$order->total_amount}}</p>
                <p style="text-align: right"><b>Status: </b>{{$order->status}}</p>
            </div>
        </div>
    </div>
    <!-- Order Details End -->

@endsection
