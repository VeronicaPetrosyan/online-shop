@extends('layouts.main')
@section('content')
    <div class="container-fluid page-header py-5">
        <h1 class="text-center text-white display-6">Orders</h1>
        <ol class="breadcrumb justify-content-center mb-0">
            <li class="breadcrumb-item"><a href="{{'/'}}">Home</a></li>
            <li class="breadcrumb-item active text-white">Orders</li>
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
                <a href="{{ route('admin.orders.export') }}" class="btn btn-success">Export Orders to CSV</a>
                <a href="{{ route('admin.orders.export.excel') }}" class="btn btn-success">Export Orders to Excel</a>

                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">Order Id</th>
                        <th scope="col">Products</th>
                        <th scope="col">Total Amount</th>
                        <th scope="col">Created At</th>
                        <th scope="col">Updated At</th>
                        <th scope="col">Actions</th>
                    </tr>
                    <tr>
                        <form method="GET" action="{{ route('admin.orders.index') }}">
                            <th>
                                <input type="text" name="order_id" class="form-control"
                                       value="{{ request('order_id') }}" placeholder="Order ID">
                            </th>
                            <th>
                                <input type="text" name="product_names" class="form-control"
                                       value="{{ request('product_names') }}" placeholder="Product Names">
                            </th>
                            <th>
                                <input type="number" name="total_amount" class="form-control"
                                       value="{{ request('total_amount') }}" placeholder="Total Amount">
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
                    @foreach($orders as $order)
                        <tr>
                            <td>
                                <p class="mb-0 mt-4"><b>{{ $order->id }}</b></p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $order->product_names }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">${{ $order->total_amount }}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $order->created_at ? $order->created_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td>
                                <p class="mb-0 mt-4">{{ $order->updated_at ? $order->updated_at->format('F d, Y') : 'N/A'}}</p>
                            </td>
                            <td style="display: flex; flex-direction: column; height: 97px">
                                <a href="{{ route('admin.orders.show', $order->id) }}"
                                   style="margin: 10px 0; line-height: 3.2">
                                    See order</a>
                            </td>
                        </tr>

                    @endforeach

                    </tbody>
                </table>
                <form action="{{ route('orders.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label for="file">Select Excel file:</label>
                        <input type="file" name="file" id="file" required>
                    </div>
                    <button type="submit" class="btn btn-primary" style="margin-top: 10px">Import Orders</button>
                </form>
                {{ $orders->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </div>
@endsection
