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

<div class="container mx-auto mt-8">
    <h1 class="text-2xl font-bold mb-4">Create New Storekeeper</h1>

    <form action="{{ route('admin.storekeepers.store') }}" method="POST" class="bg-white p-6 rounded-lg shadow-md">
        @csrf

        <!-- Name -->
        <div class="form-group mb-4">
            <label for="name" class="block text-sm font-medium text-gray-700">Name</label>
            <input type="text" name="name" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Email -->
        <div class="form-group mb-4">
            <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
            <input type="email" name="email" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Phone -->
        <div class="form-group mb-4">
            <label for="phone" class="block text-sm font-medium text-gray-700">Phone</label>
            <input type="text" name="phone" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Password -->
        <div class="form-group mb-4">
            <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
            <input type="password" name="password" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Password Confirmation -->
        <div class="form-group mb-4">
            <label for="password_confirmation" class="block text-sm font-medium text-gray-700">Confirm Password</label>
            <input type="password" name="password_confirmation" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- ID Number -->
        <div class="form-group mb-4">
            <label for="id_number" class="block text-sm font-medium text-gray-700">ID Number</label>
            <input type="text" name="id_number" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Availability -->
        <div class="form-group mb-4">
            <label for="availability" class="block text-sm font-medium text-gray-700">Availability</label>
            <input type="text" name="availability" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- City -->
        <div class="form-group mb-4">
            <label for="city" class="block text-sm font-medium text-gray-700">City</label>
            <input type="text" name="city" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <!-- Neighborhood -->
        <div class="form-group mb-4">
            <label for="neighborhood" class="block text-sm font-medium text-gray-700">Neighborhood</label>
            <input type="text" name="neighborhood" class="mt-1 block w-full border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200" required>
        </div>

        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-2 rounded-md">Create</button>

        @if ($errors->any())
            <div class="mt-4 bg-red-100 border border-red-400 text-red-700 p-3 rounded relative" role="alert">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    </form>
</div>
@endsection
