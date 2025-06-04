@extends('layout.app')

@section('content')
<div class="container">
    <h1>Storekeeper Dashboard</h1>
    @if (auth()->check())
    <h1 class="text-3xl font-bold mb-4">Bienvenue, {{ auth()->user()->name }}!</h1>
    <p class="mb-4">Solde du portefeuille:<b> {{ number_format(auth()->user()->wallet->balance, 2) }} </b>FCFA</p>

        <a href="{{ route('wallet.transaction.form') }}" class="btn-primary">Gérer mon portefeuille</a>
    <!-- Display Profile Picture -->
    <div class="mb-4">
        @if (auth()->user()->profileImage)
            <img src="{{ asset('storage/' . auth()->user()->profileImage->image_path) }}" alt="Profile Image" class="w-24 h-24 rounded-full" style="border-radius: 50%;width:35px;height:35px;">
    
            @else

            <img src="{{ asset('default-profile.png') }}" alt="Default Profile Image" class="w-24 h-24 rounded-full" style="border-radius: 50%;width:75px;height:75px;">
            <a href="{{ route('profile.edit')}}">Add profile</a> 

            @endif
    </div>

    <!-- Button to upgrade to Merchant Client -->
   
@else
    <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
    <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
@endif 
    <!-- Other dashboard content -->
</div>
@endsection
