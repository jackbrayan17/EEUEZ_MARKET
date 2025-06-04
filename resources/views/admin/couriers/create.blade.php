@extends('layout.app')

@section('content')
<header class="bg-blue-900 p-4"> 
    <div class="container mx-auto flex justify-between items-center">
        <!-- Logo on the left -->
        <div class="flex items-center">
           <a href="/admin/dashboard"> 
               <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
           </a>
           <span class="text-white text-xl font-semibold">Admin Dashboard</span>
        </div>

        <!-- Navigation Links -->
        <nav class="flex items-center space-x-4">
            <ul class="flex space-x-4 text-white">
                <li><a href="{{ route('admin.couriers.index') }}" class="hover:underline">Manage Couriers</a></li>
                <li><a href="{{ route('admin.storekeepers.index') }}" class="hover:underline">Manage Storekeepers</a></li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="hover:underline">Logout</a>
                </li>
            </ul>
        </nav>
        
        <!-- Logout Form -->
        <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            @csrf
        </form>
    </div>
</header>

<div class="container mx-auto p-6 bg-white shadow-md rounded-lg">
    <h1 class="text-2xl font-bold text-gray-800 mb-6">Create New Courier</h1>

    <form action="{{ route('admin.couriers.store') }}" method="POST" class="space-y-4">
        @csrf
        <!-- Name -->
        <div>
            <label for="name" class="block text-gray-700 font-semibold">Name</label>
            <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Email -->
        <div>
            <label for="email" class="block text-gray-700 font-semibold">Email</label>
            <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Phone -->
        <div>
            <label for="phone" class="block text-gray-700 font-semibold">Phone</label>
            <input type="text" name="phone" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Password -->
        <div>
            <label for="password" class="block text-gray-700 font-semibold">Password</label>
            <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Password Confirmation -->
        <div>
            <label for="password_confirmation" class="block text-gray-700 font-semibold">Confirm Password</label>
            <input type="password" name="password_confirmation" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- ID Number -->
        <div>
            <label for="id_number" class="block text-gray-700 font-semibold">ID Number</label>
            <input type="text" name="id_number" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Vehicle Brand -->
        <div>
            <label for="vehicle_brand" class="block text-gray-700 font-semibold">Vehicle Brand</label>
            <input type="text" name="vehicle_brand" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Vehicle Registration Number -->
        <div>
            <label for="vehicle_registration_number" class="block text-gray-700 font-semibold">Vehicle Registration Number</label>
            <input type="text" name="vehicle_registration_number" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Vehicle Color -->
        <div>
            <label for="vehicle_color" class="block text-gray-700 font-semibold">Vehicle Color</label>
            <input type="text" name="vehicle_color" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Availability -->
        <div>
            <label for="availability" class="block text-gray-700 font-semibold">Availability</label>
            <input type="text" name="availability" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- City -->
        <div>
            <label for="city" class="block text-gray-700 font-semibold">City</label>
            <input type="text" name="city" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Neighborhood -->
        <div>
            <label for="neighborhood" class="block text-gray-700 font-semibold">Neighborhood</label>
            <input type="text" name="neighborhood" class="w-full px-4 py-2 border rounded-lg" required>
        </div>

        <!-- Submit Button -->
        <button type="submit" class="bg-green-500 text-white px-6 py-2 rounded hover:bg-green-600 transition">Create</button>

        <!-- Error Display -->
        @if ($errors->any())
        <div class="mt-4 p-4 bg-red-100 text-red-700 rounded-lg">
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif
    </form>
</div>
@endsection
