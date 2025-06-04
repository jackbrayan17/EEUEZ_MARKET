@extends('layout.app')

@section('content')

<div class="container mx-auto px-4 py-8">
    @if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/client/dashboard"> 
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
                <h1 class="text-3xl font-bold"> {{ auth()->user()->name }}!</h1>
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

    <!-- Button to upgrade to Merchant Client -->
    <form method="GET" action="{{ route('client.upgrade.form') }}" class="mb-6">
        <button type="submit" class="bg-orange-500 text-white font-semibold py-2 px-4 rounded hover:bg-orange-600 transition duration-300">Devenir Merchant Client</button>
    </form>
    
@else
    <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
    <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
@endif

    <h2 class="text-2xl font-bold mb-6">Mon Profil</h2>
    
    <form method="POST" action="{{ route('client.profile.update') }}" class="bg-white p-6 rounded-lg shadow-md">
        @csrf
        @method('PUT')
        
        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Nom Complet</label>
            <input type="text" name="name" value="{{ auth()->user()->name }}" required class="input-field border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Email</label>
            <input type="email" name="email" value="{{ auth()->user()->email }}" required class="input-field border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <div class="mb-4">
            <label class="block text-gray-700 text-sm font-semibold mb-2">Numéro de Téléphone</label>
            <input type="text" name="phone" value="{{ auth()->user()->phone }}" required class="input-field border border-gray-300 rounded-md p-2 w-full focus:outline-none focus:ring-2 focus:ring-green-500">
        </div>

        <button type="submit" class="btn-primary bg-green-500 text-white font-semibold py-2 px-4 rounded hover:bg-green-600 transition duration-300">Mettre à Jour</button>
    </form>
</div>

@endsection
