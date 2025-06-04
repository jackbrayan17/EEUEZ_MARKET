@extends('layouts.merchant')

@section('content')
    <h1>Order Notifications</h1>

    <ul class="nav nav-tabs">
        <li class="nav-item">
            <a class="nav-link active" href="#pending" data-toggle="tab">Pending</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#in-transit" data-toggle="tab">In Transit</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#success" data-toggle="tab">Success</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#canceled" data-toggle="tab">Canceled</a>
        </li>
    </ul>

    <div class="tab-content">
        <div class="tab-pane fade show active" id="pending">
            <h3>Pending Orders</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendingOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->client->name }}</td>
                            <td>
                                <a href="{{ route('merchant.orders.show', $order->id) }}" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="in-transit">
            <h3>Orders In Transit</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($inTransitOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->client->name }}</td>
                            <td>
                                <a href="{{ route('merchant.orders.show', $order->id) }}" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="success">
            <h3>Completed Orders</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($successOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->client->name }}</td>
                            <td>
                                <a href="{{ route('merchant.orders.show', $order->id) }}" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="canceled">
            <h3>Canceled Orders</h3>
            <table class="table">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product</th>
                        <th>Customer</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($canceledOrders as $order)
                        <tr>
                            <td>{{ $order->id }}</td>
                            <td>{{ $order->product->name }}</td>
                            <td>{{ $order->client->name }}</td>
                            <td>
                                <a href="{{ route('merchant.orders.show', $order->id) }}" class="btn btn-info">View</a>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
