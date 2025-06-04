@extends('layout.app')

@section('content')
<div class="container">
    <h1 class="text-xl font-bold">Order Details (Client)</h1>

    <div class="my-4">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Courier:</strong> {{ $order->courier->name ?? 'Not assigned yet' }}</p>
        <p><strong>Delivery Address:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Products:</strong></p>
        <ul>
            @foreach($order->products as $product)
                <li>{{ $product->name }} - {{ $product->pivot->quantity }} pcs</li>
            @endforeach
        </ul>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    @if($order->status == 'in_transit')
        <a href="{{ route('orders.tracking', $order->id) }}" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
            Track Delivery
        </a>
        <form action="{{ route('orders.cancel', $order->id) }}" method="POST" class="inline">
            @csrf
            <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                Cancel Order
            </button>
        </form>
    @elseif($order->status == 'completed')
        <p>Thank you for your order! Please leave a review.</p>
        <!-- Add review form here -->
    @endif
</div>
@endsection
