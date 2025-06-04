@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
    @if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/courier/dashboard"> 
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
            </a>
        </div>

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
    @endif
    <h1 class="text-2xl font-bold mb-4">Détails de la Commande (Livreur)</h1>

    <div class="my-4 p-4 bg-white shadow rounded">
        <p><strong>Order ID:</strong> {{ $order->id }}</p>
        <p><strong>Client:</strong> {{ $order->client->name }}</p>
        <p><strong>Adresse de Livraison:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Produits:</strong></p>
        <ul class="list-disc list-inside">
            @foreach($order->products as $product)
                <li>{{ $product->name }} - {{ $product->pivot->quantity }} pcs</li>
            @endforeach
        </ul>
        <p><strong>Status:</strong> {{ ucfirst($order->status) }}</p>
    </div>

    @if($order->status == 'pending')
        <form action="{{ route('orders.startDelivery', $order->id) }}" method="POST">
            @csrf
            <button type="submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                Commencer la Livraison
            </button>
        </form>
    @elseif($order->status == 'in_transit')
        <form action="{{ route('orders.verifyCode', $order->id) }}" method="POST" class="my-4">
            @csrf
            <div class="my-2">
                <label for="verification_code" class="block font-medium">Entrer le Code de Livraison:</label>
                <input type="text" name="verification_code" class="border rounded px-2 py-1 w-full" required>
            </div>
            <button type="submit" class="bg-green-500 hover:bg-green-700 text-white font-bold py-2 px-4 rounded">
                Terminer la Livraison
            </button>
        </form>
    @endif
</div>
@endsection
