@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
    @if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/client/dashboard"> 
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
    
    <!-- Wallet Information Card -->
    <div class="bg-green-500 p-4 rounded-lg shadow mb-6 transition duration-300 hover:bg-green-600">
        <h2 class="text-xl font-semibold text-white">Wallet Amount</h2>
        <p class="text-lg text-white"><b>{{ number_format(auth()->user()->wallet->balance, 2) }} FCFA</b></p>
        <a href="{{ route('wallet.transaction.form') }}" class="bg-white text-green-600 font-semibold py-2 px-4 rounded mt-2 inline-block hover:bg-gray-100 transition duration-300">Gérer mon portefeuille</a>
    </div>

    <!-- Button to upgrade to Merchant Client -->
    
    
    @else
        <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
        <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
    @endif

    <h1 class="text-3xl font-bold mb-4">Produits Disponibles</h1>
    
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
        @foreach($products as $product)
            <div class="bg-white p-4 rounded-lg shadow-md transition duration-300 hover:shadow-lg">
                <!-- Display the product image -->
                <div class="flex justify-center mb-4">
                    @if($product->images->count())
                        <img src="{{ asset('storage/' . $product->images->first()->image_path) }}" alt="Product Image" class="w-32 h-32 object-cover rounded-md">
                    @else
                        <p class="text-gray-500">No Image</p>
                    @endif
                </div>

                <h2 class="text-xl font-semibold mb-2">{{ $product->name }}</h2>
                <p class="text-gray-700 mb-2">{{ $product->description }}</p>
                <p class="font-bold text-lg mb-4">Prix: {{ number_format($product->price, 2) }} FCFA</p>
                <a href="{{ route('orders.create', $product->id) }}" class="bg-blue-500 text-white font-semibold py-2 px-4 rounded hover:bg-blue-600 transition duration-300">Commander</a>
            </div>
        @endforeach
    </div>
</div>
@endsection
