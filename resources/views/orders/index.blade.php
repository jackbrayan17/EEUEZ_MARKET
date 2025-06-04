@extends('layout.app')

@section('content')
    <h1 class="text-2xl font-bold mb-4">All Orders</h1>

    <table class="min-w-full border-collapse border border-gray-300">
        <thead>
            <tr>
                <th class="border border-gray-300 px-4 py-2">Order ID</th>
                <th class="border border-gray-300 px-4 py-2">Sender</th>
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
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ ucfirst($order->status) }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            {{-- <a href="{{ route('orders.show', $order->id) }}" class="text-blue-500">View</a> --}}

                            {{-- Actions based on user role --}}
                            @if(Auth::user()->hasRole('Admin'))
                                <a href="{{ route('admin.orders.edit', $order->id) }}" class="text-yellow-500">Edit</a>
                                <form action="{{ route('admin.orders.delete', $order->id) }}" method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500">Delete</button>
                                </form>
                            @elseif(Auth::user()->hasRole('Merchant Client'))
                                {{-- Merchant-specific actions --}}
                                <a href="{{ route('merchant.orders.track', $order->id) }}" class="text-green-500">Track</a>
                            @elseif(Auth::user()->hasRole('Client'))
                                {{-- Client-specific actions --}}
                                @if($order->status == 'in_transit')
                                    <a href="{{ route('client.orders.track', $order->id) }}" class="text-green-500">Track</a>
                                @elseif($order->status == 'pending')
                                    <form action="{{ route('client.orders.cancel', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-red-500">Cancel</button>
                                    </form>
                                @endif
                            @elseif(Auth::user()->hasRole('Courier'))
                                {{-- Courier-specific actions --}}
                                @if($order->status == 'pending')
                                    <form action="{{ route('courier.orders.start', $order->id) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="text-blue-500">Start Delivery</button>
                                    </form>
                                @elseif($order->status == 'in_transit')
                                    <a href="{{ route('courier.orders.complete', $order->id) }}" class="text-green-500">Complete</a>
                                @endif
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
@endsection
