@extends('layout.app')

@section('content')
@if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/client/dashboard"> 
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
            </a>  <span>Add Profile Picture</span> </div>
    
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
<form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" class="max-w-lg mx-auto p-4 bg-white rounded-lg shadow-md">
    @csrf
    @method('PUT')

    <div class="mb-4">
        <label for="profile_image" class="block text-sm font-medium text-gray-700">Upload Profile Picture</label>
        <input type="file" name="profile_image" id="profile_image" accept="image/*" 
            class="mt-1 block w-full text-sm text-gray-900 border border-gray-300 rounded-md focus:border-blue-500 focus:ring focus:ring-blue-200" 
            onchange="previewImage(event)">
    </div>

    <div class="mb-4">
        <img id="image_preview" class="hidden w-full h-auto rounded-md" alt="Profile Image Preview">
    </div>

    <button type="submit" class="w-full px-4 py-2 text-white bg-blue-600 rounded-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-opacity-50">Update Profile</button>
</form>

<script>
function previewImage(event) {
    const imagePreview = document.getElementById('image_preview');
    const file = event.target.files[0];
    const reader = new FileReader();

    reader.onload = function(e) {
        imagePreview.src = e.target.result;
        imagePreview.classList.remove('hidden'); // Show the image
    }

    if (file) {
        reader.readAsDataURL(file);
    } else {
        imagePreview.classList.add('hidden'); // Hide the image if no file is selected
    }
}
</script>
@endsection