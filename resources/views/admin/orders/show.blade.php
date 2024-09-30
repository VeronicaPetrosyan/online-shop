@extends('layouts.main')
@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Order Details</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item"><a href="{{route('admin.orders.index')}}">Orders</a></li>
            <li class="breadcrumb-item active text-white">Order Details</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Order Details Page Start -->
    <div class="container-fluid py-5">
        <div class="container py-5">
            <h1 class="mb-4">Order details</h1>
            <div class="row g-5">
                <!-- Order Details Left Start -->
                <div class="col-md-12 col-lg-6 col-xl-7">
                    <div class="form-item w-100">
                        <p class="form-label my-3"><b>First Name:</b> {{ $order->name }}</p>
                    </div>
                    <div class="form-item w-100">
                        <p class="form-label my-3"><b>Last Name:</b> {{ $order->surname }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Address:</b> {{ $order->address }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Town/City:</b> {{ $order->city }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Country:</b> {{ $order->country }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Postcode/Zip:</b> {{ $order->postcode }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Mobile:</b> {{ $order->mobile }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Email Address:</b> {{ $order->email }}</p>
                    </div>
                    <div class="form-item">
                        <p class="form-label my-3"><b>Order Notes:</b> {{ $order->notes }}</p>
                    </div>
                     <div class="form-item">
                        <p class="form-label my-3"><b>Current Order Status:</b> {{ $order->status }}</p>
                    </div>

                      <div class="form-item" style="margin-top: 50px; max-width: 400px" >
                        <h3 class="form-label my-3">Change Order Status</h3>
                        <form action="{{ route('admin.order.updateStatus', $order->id) }}" method="POST" style="display: flex; flex-direction: column">
                            @csrf
                            <div class="btn-group" role="group">
                                <input type="radio" class="btn-check" name="status" id="picked-up" value="Picked Up" {{ $order->status == 'Picked Up' ? 'checked' : '' }}>
                                <label class="btn btn-success" for="picked-up">Picked up</label>

                                <input type="radio" class="btn-check" name="status" id="delivered" value="Delivered" {{ $order->status == 'Delivered' ? 'checked' : '' }}>
                                <label class="btn btn-warning" for="delivered">Delivered</label>

                            </div>
                            <button type="submit" class="btn btn-outline-primary mt-3" style="width: 150px;">Update Status</button>
                        </form>
                    </div>

                </div>
                <!-- Order Details Left End -->



                <!-- Order Items Right Start -->
                <div class="col-md-12 col-lg-6 col-xl-5">
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
                                            <div class="d-flex align-items-center mt-2">
                                                <img src="{{ asset($orderItem->product->images->first()->image) }}" class="img-fluid rounded-circle" style="width: 90px; height: 90px;" alt="">
                                            </div>
                                        </th>
                                        <td class="py-5">{{ $orderItem->product->title }}</td>
                                        <td class="py-5">${{ $orderItem->product->price }}</td>
                                        <td class="py-5">{{ $orderItem->quantity }}</td>
                                        <td class="py-5">${{ $orderItem->product->price * $orderItem->quantity }}</td>
                                    </tr>
                                @endforeach
                                <tr>
                                    <th scope="row"></th>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Subtotal</p>
                                    </td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">+</p>
                                    </td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark py-3">Shipping: </p>
                                    </td>
                                    <td class="py-5">
                                        <p class="mb-0 text-dark" style="line-height: 3.5;"><b>${{ $order->total_amount + 3 }}</b></p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
                <!-- Order Items Right End -->
            </div>
        </div>
    </div>
    <!-- Order Details Page End -->

@endsection
