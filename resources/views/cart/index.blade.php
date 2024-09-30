@extends('layouts.main')
@section('content')

    <!-- Single Page Header start -->
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Cart</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">My Cart</li>
        </ol>
    </div>
    <!-- Single Page Header End -->

    <!-- Cart Page Start -->
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

            @if($cartItems->isEmpty())
                <div class="text-center">
                    <p>No products are found in cart.</p>
                </div>
            @else
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">Products</th>
                            <th scope="col">Name</th>
                            <th scope="col">Price</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Total</th>
                            <th scope="col">Handle</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($cartItems as $cartItem)
                            <tr data-cart-item-id="{{ $cartItem->id }}">
                                <th scope="row">
                                    <div class="d-flex align-items-center" style="width: 80px; height: 80px;">
                                        <img src="{{asset($cartItem->product->images->first()->image)}}"
                                             class="img-fluid me-5 rounded-circle"
                                             alt="">
                                    </div>
                                </th>
                                <td>
                                    <p class="mb-0 mt-4">{{$cartItem->product->title}}</p>
                                </td>
                                <td>
                                    <p class="mb-0 mt-4 product-price">${{$cartItem->product->price}}</p>
                                </td>
                                <td>
                                    <div class="input-group quantity mt-4" style="width: 100px;">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-minus rounded-circle bg-light border">
                                                <i class="fa fa-minus"></i>
                                            </button>
                                        </div>
                                        <input type="text"
                                               class="form-control form-control-sm text-center border-0 quantity-input"
                                               value="{{$cartItem->quantity}}">
                                        <div class="input-group-btn">
                                            <button class="btn btn-sm btn-plus rounded-circle bg-light border">
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td class="item-total">
                                    <p class="mb-0 mt-4">${{$cartItem->quantity * $cartItem->product->price}}</p>
                                </td>
                                <td>
                                    <form action="{{ route('cart.remove', $cartItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-md rounded-circle bg-light border mt-4" title="Delete from cart">
                                            <i class="fa fa-times text-danger"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="row g-4 justify-content-end">
                    <div class="col-8"></div>
                    <div class="col-sm-8 col-md-7 col-lg-6 col-xl-4">
                        <div class="bg-light rounded">
                            <div class="p-4">
                                <h1 class="display-6 mb-4">Cart <span class="fw-normal">Total</span></h1>
                                <div class="d-flex justify-content-between mb-4">
                                    <h5 class="mb-0 me-4">Subtotal:</h5>
                                    <p class="mb-0" id="subtotalAmount">${{$totalAmount}}</p>
                                </div>
                                <div class="d-flex justify-content-between">
                                    <h5 class="mb-0 me-4">Shipping</h5>
                                    <div class="">
                                        <p class="mb-0">Fee: $3.00</p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-4 mb-4 border-top border-bottom d-flex justify-content-between">
                                <h5 class="mb-0 ps-4 me-4">Total</h5>
                                <p class="mb-0 pe-4" id="totalAmount">${{$totalAmount + 3}}</p>
                            </div>
                            @if(Auth::guard('web')->check())
                                <a href="{{route('checkout.index')}}"
                                   class="btn border-secondary rounded-pill px-4 py-3 text-primary text-uppercase mb-4 ms-4"
                                   type="button">Proceed Checkout
                                </a>
                            @else
                                <a href="{{'/login'}}"
                                   class="btn border-secondary rounded-pill px-4 py-3
                                   text-primary text-uppercase mb-4 ms-4">
                                    Login for Checkout
                                </a>
                            @endif

                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <!-- Cart Page End -->

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            function updateItemTotal(input) {
                const tr = input.closest('tr');
                const quantity = parseInt(input.value);
                const cartItemId = tr.dataset.cartItemId;

                const priceElement = tr.querySelector('.product-price');
                if (priceElement) {
                    const price = parseFloat(priceElement.innerText.slice(1));
                    const total = quantity * price;
                    const itemTotalElement = tr.querySelector('.item-total p');
                    if (itemTotalElement) {
                        itemTotalElement.innerText = `$${total.toFixed(2)}`;
                    }
                    updateCartTotal();
                }

                fetch(`/cart/update/${cartItemId}`, {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
                    },
                    body: JSON.stringify({quantity: quantity})
                }).then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            console.log('Quantity updated successfully');
                        } else {
                            console.error('Failed to update quantity');
                        }
                    });
            }

            function updateCartTotal() {
                let subtotal = 0;
                document.querySelectorAll('.item-total p').forEach(itemTotal => {
                    subtotal += parseFloat(itemTotal.innerText.slice(1));
                });
                const shipping = 3.00;
                const totalAmount = subtotal + shipping;

                const subtotalElement = document.getElementById('subtotalAmount');
                if (subtotalElement) {
                    subtotalElement.innerText = `$${subtotal.toFixed(2)}`;
                }

                const totalAmountElement = document.getElementById('totalAmount');
                if (totalAmountElement) {
                    totalAmountElement.innerText = `$${totalAmount.toFixed(2)}`;
                }
            }

            document.querySelectorAll('.quantity-input').forEach(input => {
                input.addEventListener('change', function () {
                    updateItemTotal(this);
                });
            });

            document.querySelectorAll('.btn-minus').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const input = this.closest('.quantity').querySelector('.quantity-input');
                    if (input.value > 1) {
                        input.value = parseInt(input.value);
                        updateItemTotal(input);
                    }
                });
            });

            document.querySelectorAll('.btn-plus').forEach(button => {
                button.addEventListener('click', function (event) {
                    event.preventDefault();
                    const input = this.closest('.quantity').querySelector('.quantity-input');
                    input.value = parseInt(input.value);
                    updateItemTotal(input);
                });
            });

            updateCartTotal();
        });
    </script>
@endsection
