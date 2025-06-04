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


    <h2 class="text-2xl font-semibold mb-6">Add Product to {{ $storefront->name }}</h2>

    <form action="{{ route('merchant.storefront.add-product') }}" method="POST" class="bg-white shadow-md rounded p-6">
        @csrf
        <input type="hidden" name="storefront_id" value="{{ $storefront->id }}">

        <div class="mb-4">
            <label class="block text-gray-700">Product Name</label>
            <input type="text" name="name" class="border rounded w-full p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Description</label>
            <textarea name="description" class="border rounded w-full p-2 mt-1" required></textarea>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Price</label>
            <input type="text" name="price" class="border rounded w-full p-2 mt-1" required>
        </div>

        <div class="mb-4">
            <label class="block text-gray-700">Stock</label>
            <input type="number" name="stock" class="border rounded w-full p-2 mt-1" required>
        </div>

        <button type="submit" class="bg-blue-500 text-white p-3 rounded hover:bg-blue-600 transition duration-200">Add Product</button>
    </form>
</div>
@endsection
