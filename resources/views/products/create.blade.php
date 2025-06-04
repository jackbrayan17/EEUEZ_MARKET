@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
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
    <h1 class="text-3xl font-bold mb-6">Add Product</h1>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data" class="bg-white shadow-md rounded-lg p-6">
        @csrf
        <input type="hidden" name="storefront_id" value="{{ $storefrontId }}">
        <input type="hidden" name="merchant_id" value="{{ auth()->user()->merchant->id }}">

        <div class="mb-4">
            <label for="name" class="block text-gray-700 font-semibold mb-2">Product Name</label>
            <input type="text" name="name" id="name" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="description" class="block text-gray-700 font-semibold mb-2">Description</label>
            <textarea name="description" id="description" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500"></textarea>
        </div>

        <div class="mb-4">
            <label for="price" class="block text-gray-700 font-semibold mb-2">Price</label>
            <input type="number" name="price" id="price" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" step="0.01" required>
        </div>

        <div class="mb-4">
            <label for="stock" class="block text-gray-700 font-semibold mb-2">Stock</label>
            <input type="number" name="stock" id="stock" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" required>
        </div>

        <div class="mb-4">
            <label for="category_id" class="block text-gray-700 font-semibold mb-2">Category</label>
            <select name="category_id" id="category_id" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" required>
                <option value="">Select Category</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-4">
            <label for="images" class="block text-gray-700 font-semibold mb-2">Product Images</label>
            <div id="image-fields">
                <input type="file" name="images[]" class="form-control block w-full px-4 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring focus:ring-blue-500" multiple accept="image/*">
            </div>
            <button type="button" id="add-image" class="mt-2 bg-gray-300 text-gray-700 px-4 py-2 rounded-md hover:bg-gray-400 transition duration-200">Add Pictures</button>
        </div>

        <div id="image-preview" class="mb-4 grid grid-cols-2 gap-4"></div> <!-- Preview Container with Grid -->

        <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded-md hover:bg-blue-600 transition duration-200">Add Product</button>
    </form>

    <script>
        document.getElementById('add-image').addEventListener('click', function() {
            const imageFieldsContainer = document.getElementById('image-fields');
            const newImageInput = document.createElement('input');
            newImageInput.type = 'file';
            newImageInput.name = 'images[]';
            newImageInput.className = 'form-control block w-full px-4 py-2 border border-gray-300 rounded-md mt-2 focus:outline-none focus:ring focus:ring-blue-500';
            newImageInput.accept = 'image/*'; // Accept only images
            
            // Add event listener to display preview
            newImageInput.addEventListener('change', function(event) {
                displayImagePreview(event.target.files);
            });

            imageFieldsContainer.appendChild(newImageInput);
        });

        // Function to display image previews
        function displayImagePreview(files) {
            const previewContainer = document.getElementById('image-preview');
            const currentImages = Array.from(previewContainer.getElementsByTagName('img')); // Get current images
            
            // Loop through all selected files and display them
            Array.from(files).forEach(file => {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const img = document.createElement('img');
                    img.src = e.target.result;
                    img.className = 'w-24 h-24 object-cover rounded-md shadow-md mr-2 mb-2'; // Add some styling
                    previewContainer.appendChild(img);
                };
                reader.readAsDataURL(file);
            });
        }

        // Add change listener to the initial image input
        const initialImageInput = document.querySelector('input[type="file"]');
        initialImageInput.addEventListener('change', function(event) {
            displayImagePreview(event.target.files);
        });
    </script>
</div>
@endsection
