@extends('layout.app')

@section('content')
<div class="container mx-auto p-6 bg-white rounded-lg shadow-md">
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
    
    <h2 class="text-2xl font-bold mb-4">Devenir Merchant Client</h2>
    <p class="mb-4">Vous serez facturé 1000 FCFA pour devenir un Merchant Client.</p>

    <form method="POST" action="{{ route('client.upgrade') }}" class="space-y-4">
        @csrf

        <fieldset class="border border-gray-300 rounded-md p-4">
            <legend class="font-semibold text-lg">Choisissez votre méthode de paiement:</legend>
            <div class="flex items-center mb-2">
                <input type="radio" name="payment_method" value="Orange Money" id="orange_money" class="mr-2" required>
                <label for="orange_money" class="cursor-pointer">Orange Money</label>
            </div>
            <div class="flex items-center mb-2">
                <input type="radio" name="payment_method" value="MTN Momo" id="mtn_momo" class="mr-2" required>
                <label for="mtn_momo" class="cursor-pointer">MTN Momo</label>
            </div>
        </fieldset>

        <label for="phone" class="block font-medium">Numéro de téléphone:</label>
        <input type="text" name="phone" id="phone" required class="form-input block w-full border border-gray-300 rounded-md p-2" placeholder="Votre numéro de téléphone">

        <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 rounded-md hover:bg-blue-600 transition duration-300">Confirmer le Paiement</button>
    </form>
</div>
@endsection
