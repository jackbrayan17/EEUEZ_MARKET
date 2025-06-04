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

    <!-- Button to upgrade to Merchant Client -->
    <form method="GET" action="{{ route('client.upgrade.form') }}" class="mb-6">
        <button type="submit" class="bg-orange-500 text-white font-semibold py-2 px-4 rounded hover:bg-orange-600 transition duration-300">Devenir Merchant Client</button>
    </form>
    
@else
    <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
    <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
@endif
