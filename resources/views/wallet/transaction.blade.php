@extends('layout.app')

@section('content')
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
            <h1 class="text-3xl font-bold">{{ auth()->user()->name }}!</h1>
        </div>

        <form method="POST" action="{{ route('logout') }}" class="ml-4">
            @csrf
            <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
        </form>
    </div>
</header>
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
    <h1 class="text-3xl font-bold mb-6">Votre portefeuille</h1>

    <p class="mb-4 text-lg">Solde actuel: <span class="font-semibold">{{ number_format($wallet->balance, 2) }} FCFA</span></p>

    <!-- Deposit Form -->
    <form action="{{ route('wallet.deposit') }}" method="POST" class="mb-8 p-4 bg-gray-100 rounded-lg shadow">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Déposer des fonds</h2>

        <label for="transaction_type" class="block mb-2 font-medium">Choisir le type de transaction:</label>
        <select name="transaction_type" class="form-select mb-4 block w-full border border-gray-300 rounded-md p-2" required>
            <option value="MTN">MTN MoMo</option>
            <option value="Orange">Orange Money</option>
        </select>

        <label for="phone_number" class="block mb-2 font-medium">Numéro de téléphone (MTN ou Orange):</label>
        <input type="text" name="phone_number" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required placeholder="Numéro de transaction">

        <label for="amount" class="block mb-2 font-medium">Montant à déposer:</label>
        <input type="number" name="amount" step="0.01" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required>

        <button type="submit" class="w-full bg-green-500 text-white font-semibold py-2 rounded-md hover:bg-green-600 transition duration-300">Déposer</button>
    </form>

    <!-- Withdraw Form -->
    <form action="{{ route('wallet.withdraw') }}" method="POST" class="p-4 bg-gray-100 rounded-lg shadow">
        @csrf
        <h2 class="text-xl font-semibold mb-4">Retirer des fonds</h2>

        <label for="transaction_type" class="block mb-2 font-medium">Choisir le type de transaction:</label>
        <select name="transaction_type" class="form-select mb-4 block w-full border border-gray-300 rounded-md p-2" required>
            <option value="MTN">MTN MoMo</option>
            <option value="Orange">Orange Money</option>
        </select>

        <label for="phone_number" class="block mb-2 font-medium">Numéro de téléphone (MTN ou Orange):</label>
        <input type="text" name="phone_number" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required placeholder="Numéro de transaction">

        <label for="amount" class="block mb-2 font-medium">Montant à retirer:</label>
        <input type="number" name="amount" step="0.01" class="form-input mb-4 block w-full border border-gray-300 rounded-md p-2" required>

        <button type="submit" class="w-full bg-red-500 text-white font-semibold py-2 rounded-md hover:bg-red-600 transition duration-300">Retirer</button>
    </form>

    <!-- Display Messages -->
    @if(session('success'))
        <p class="mt-4 text-green-500 font-semibold">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p class="mt-4 text-red-500 font-semibold">{{ session('error') }}</p>
    @endif
</div>
@endsection