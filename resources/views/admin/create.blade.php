@extends('layout.app')

@section('content')
<header class="bg-blue-900 p-4">
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo on the left -->
        <div class="flex items-center">
           <a href="/superadmin/dashboard"> <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
           </a><span class="text-white text-xl font-semibold">Super Admin Dashboard</span>
        </div>

        <!-- Authentication Links on the right -->
        <nav class="flex items-center space-x-4">
            @auth
                <!-- Show this if the user is authenticated -->
                <form action="{{ route('logout') }}" method="POST" style="display: inline;">
                    @csrf
                    <button type="submit"
                        class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-lg shadow-md focus:outline-none">
                        Logout
                    </button>
                </form>
            @endauth
            @guest
                <!-- Show this if the user is not authenticated -->
                <a href="{{ route('login') }}"
                    class="text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg shadow-md focus:outline-none">
                    Login
                </a>
                <a href="{{ route('client.register.form') }}"
                    class="text-white bg-emerald-600 hover:bg-emerald-700 px-4 py-2 rounded-lg shadow-md focus:outline-none">
                    Register
                </a>
            @endguest
        </nav>
    </div>
</header>
<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h2 class="text-2xl font-bold text-blue-900 mb-4">Créer un Administrateur</h2>

    @if ($errors->any())
        <div class="bg-red-500 text-white p-4 mb-4 rounded-lg">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.register') }}">
        @csrf
        <!-- Nom Complet -->
        <label for="name" class="block text-gray-700 font-semibold mb-2">Nom Complet</label>
        <input id="name" type="text" name="name" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent mb-4" placeholder="Entrez le nom complet" autofocus>

        <!-- Email -->
        <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
        <input id="email" type="email" name="email" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent mb-4" placeholder="Entrez l'email">

        <!-- Numéro de Téléphone -->
        <label for="phone" class="block text-gray-700 font-semibold mb-2">Numéro de Téléphone</label>
        <input id="phone" type="text" name="phone" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent mb-4" placeholder="Entrez le numéro de téléphone">

        <!-- Mot de Passe -->
        <label for="password" class="block text-gray-700 font-semibold mb-2">Mot de Passe</label>
        <input id="password" type="password" name="password" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent mb-4" placeholder="Entrez le mot de passe">

        <!-- Confirmer le Mot de Passe -->
        <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirmer le Mot de Passe</label>
        <input id="password_confirmation" type="password" name="password_confirmation" required class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-transparent mb-6" placeholder="Confirmer le mot de passe">

        <!-- Submit Button -->
        <button type="submit" class="w-full text-white bg-emerald-600 hover:bg-emerald-700 py-2 px-4 rounded-lg font-semibold focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            Créer Administrateur
        </button>
    </form>
</div>
@endsection
