@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
    @if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/client/dashboard"> 
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
            </a>  <span>Merchant Dashboard</span> </div>
    
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
    <h1 class="text-3xl font-bold mb-4">{{ $product->name }}</h1>

    <div class="mb-6">
        <h3 class="text-xl font-semibold">Category: <span class="font-normal">{{ $product->category->name }}</span></h3>
        <h3 class="text-xl font-semibold">Price: <span class="font-normal">{{ $product->price }} FCFA</span></h3>
        <h3 class="text-xl font-semibold">Stock: <span class="font-normal">{{ $product->stock }}</span></h3>
        <p class="mt-2 text-gray-700">{{ $product->description }}</p>
    </div>

    <div class="mb-6">
        <h3 class="text-xl font-semibold">Product Images:</h3>
        <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-4 gap-4 mt-2">
            @if($product->images->count())
                @foreach($product->images as $image)
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $product->name }}" class="w-full h-auto rounded-lg shadow-md">
                @endforeach
            @else
                <p class="text-gray-600">No images available for this product.</p>
            @endif
        </div>
    </div>

    <div class="flex space-x-4">
        <a href="{{ route('products.edit', $product->id) }}" class="bg-yellow-500 text-white px-4 py-2 rounded-md hover:bg-yellow-600 transition duration-200">Edit</a>
        <form action="{{ route('products.destroy', $product->id) }}" method="POST" style="display:inline;">
            @csrf
            @method('DELETE')
            <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded-md hover:bg-red-600 transition duration-200" onclick="return confirm('Are you sure?')">Delete</button>
        </form>
    </div>
</div>
@endsection
