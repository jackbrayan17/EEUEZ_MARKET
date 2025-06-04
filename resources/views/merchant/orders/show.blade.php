@extends('layout.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">Your Orders</h1>

    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Order ID</th>
                <th class="border border-gray-300 px-4 py-2">Product Name</th>
                <th class="border border-gray-300 px-4 py-2">Receiver</th>
                <th class="border border-gray-300 px-4 py-2">Status</th>
                <th class="border border-gray-300 px-4 py-2">Actions</th>
            </tr>
        </thead>
        <tbody>
            @if($orders->isEmpty())
                <tr>
                    <td colspan="5" class="text-center p-4">No orders found.</td>
                </tr>
            @else
                @foreach($orders as $order)
                    <tr>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->product->name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->status }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('orders.show', $order->id) }}" class="text-blue-500">View</a>
                            
                            @if($order->status == 'In Transit')
                                <a href="{{ route('orders.track', $order->id) }}" class="ml-4 bg-blue-500 text-white px-3 py-1 rounded">Track Order</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
