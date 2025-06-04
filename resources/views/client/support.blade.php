@extends('layout.app')

@section('content')

<div class="container mx-auto">
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/admin/dashboard"> 
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
                <h1 class="text-3xl font-bold">Bienvenue, {{ auth()->user()->name }}!</h1>
            </div>
    
            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
            </form>
        </div>
    </header>
    <h2 class="text-2xl font-bold mb-4">Support Client</h2>
    
    <form method="POST" action="{{ route('client.support.submit') }}">
        @csrf
        
        <label class="block mb-2">Sujet</label>
        <input type="text" name="subject" required class="input-field" placeholder="Entrez le sujet">

        <label class="block mb-2">Message</label>
        <textarea name="message" required class="input-field" rows="4" placeholder="Entrez votre message"></textarea>

        <button type="submit" class="btn-primary">Envoyer</button>
    </form>
</div>

@endsection
