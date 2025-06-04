@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
    @if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/merchant/dashboard"> 
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
            </a>   </div>
    
        <!-- User Info and Logout on the Right -->
        <div class="flex items-center ml-auto">
            <!-- Display Profile Picture -->
            @if (auth()->user()->profileImage)
                <img src="{{ asset('storage/' . auth()->user()->profileImage->image_path) }}" alt="Profile Image" class="w-10 h-10 rounded-full">
            @else
                <img src="{{ asset('jblogo.png') }}" alt="Default Profile Image" class="w-10 h-10 rounded-full">
                <a href="{{ route('profile.edit') }}" class="text-blue-500 ml-2">Add profile</a>
            @endif
    
            <div class="ml-2">
                <h1 class="text-3xl font-bold">{{ auth()->user()->name }}!</h1>
            </div>
    
            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
            </form>
        </div>
    </header>

        <!-- Wallet Information Card -->
        <div class="bg-green-500 p-4 rounded shadow mb-6 transition duration-300 hover:bg-green-600">
            <h2 class="text-xl font-semibold text-white">Wallet Amount</h2>
            <p class="text-lg text-white"><b>{{ number_format(auth()->user()->wallet->balance, 2) }} FCFA</b></p>
            <a href="{{ route('wallet.transaction.form') }}" class="bg-white text-green-600 font-semibold py-2 px-4 rounded mt-2 inline-block hover:bg-gray-100 transition duration-300">Gérer mon portefeuille</a>
        </div>

       
        
    @else
        <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
        <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
    @endif
    <h1 class="text-3xl font-bold mb-6">Your Orders</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white shadow-lg rounded-lg border border-gray-300">
            <thead class="bg-gray-200">
                <tr>
                    <th class="border border-gray-300 px-4 py-3 text-left text-gray-600">Order ID</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-gray-600">Product Name</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-gray-600">Receiver</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-gray-600">Status</th>
                    <th class="border border-gray-300 px-4 py-3 text-left text-gray-600">Actions</th>
                </tr>
            </thead>
            <tbody class="text-gray-700">
                @if($orders->isEmpty())
                    <tr>
                        <td colspan="5" class="text-center p-4">No orders found.</td>
                    </tr>
                @else
                    @foreach($orders as $order)
                        <tr class="border-b hover:bg-gray-100">
                            <td class="border border-gray-300 px-4 py-3">{{ $order->id }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $order->product_info }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $order->receiver_name }}</td>
                            <td class="border border-gray-300 px-4 py-3">{{ $order->status }}</td>
                            <td class="border border-gray-300 px-4 py-3">
                                <a href="{{ route('orders.show', $order->id) }}" class="text-blue-500 hover:underline">View</a>
                                
                                @if($order->status == 'In Transit')
                                    <a href="{{ route('orders.track', $order->id) }}" class="ml-4 bg-blue-500 text-white px-3 py-1 rounded hover:bg-blue-600 transition duration-200">Track Order</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
@endsection
