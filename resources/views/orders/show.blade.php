@extends('layout.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Order Details</h1>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Sender Information</h2>
        <p>Name: {{ $order->sender_name }}</p>
        <p>Phone: {{ $order->sender_phone }}</p>
        <p>Town: {{ $order->sender_town }}</p>
        <p>Quarter: {{ $order->sender_quarter }}</p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Receiver Information</h2>
        <p>Name: {{ $order->receiver_name }}</p>
        <p>Phone: {{ $order->receiver_phone }}</p>
        <p>Town: {{ $order->receiver_town }}</p>
        <p>Quarter: {{ $order->receiver_quarter }}</p>
    </div>

    <div class="mb-4">
        <h2 class="text-lg font-semibold">Order Status: {{ $order->status }}</h2>
    </div>

    @if ($isCourier && $order->status === 'Pending')
        <form action="{{ route('courier.startDelivery', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded">Start Delivery</button>
        </form>
    @endif

    @if ($isClient && $order->status === 'In Transit')
        <a href="{{ route('tracking.page', $order->id) }}" class="text-blue-500">Track Your Order</a>
    @endif

    @if ($isMerchant && $order->status === 'In Transit')
        <a href="{{ route('tracking.page', $order->id) }}" class="text-blue-500">View Tracking</a>
    @endif

    <a href="{{ route('orders.index') }}" class="text-blue-500 mt-4">Back to Orders</a>
@endsection
