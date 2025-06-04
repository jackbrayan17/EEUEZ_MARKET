@extends('layout.app')

@section('content')

<div class="container mx-auto">
    <h1 class="text-3xl font-bold mb-4">Tableau de Bord du Merchant</h1>
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


    <div class="bg-white shadow-md rounded p-6">
        <h2 class="text-xl font-semibold mb-4">Manage Your Products</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div class="border rounded p-4 hover:shadow-lg transition-shadow duration-200">
                <h3 class="font-medium mb-2">Add Storefront</h3>
                <p class="text-gray-600 mb-2">Create a new storefront to display your products.</p>
                <a href="{{ route('merchant.storefront.create') }}" class="text-blue-600 hover:underline">Go to Add Storefront</a>
            </div>

            <div class="border rounded p-4 hover:shadow-lg transition-shadow duration-200">
                <h3 class="font-medium mb-2">View Storefront</h3>
                <p class="text-gray-600 mb-2">Manage and edit your existing storefronts.</p>
                <a href="{{ route('merchant.storefronts') }}" class="text-blue-600 hover:underline">Go to View Storefront</a>
            </div>

            {{-- Uncomment if needed --}}
            {{-- <div class="border rounded p-4 hover:shadow-lg transition-shadow duration-200">
                <h3 class="font-medium mb-2">View Your Products</h3>
                <p class="text-gray-600 mb-2">Check all the products you have listed.</p>
                <a href="{{ route('products.index') }}" class="text-blue-600 hover:underline">Go to View Your Products</a>
            </div> --}}
        </div>
    </div>

    <!-- Manage Orders Card -->
    <div class="bg-white shadow-md rounded p-6 mt-6">
        <h2 class="text-xl font-semibold mb-4">Manage Orders</h2>
        <div class="border rounded p-4 hover:shadow-lg transition-shadow duration-200">
            <h3 class="font-medium mb-2">See Orders</h3>
            <p class="text-gray-600 mb-2">Review and manage all your incoming orders.</p>
            <a href="{{ route('merchant.orders.index') }}" class="text-blue-600 hover:underline">Go to See Orders</a>
        </div>
    </div>
</div>

@endsection
