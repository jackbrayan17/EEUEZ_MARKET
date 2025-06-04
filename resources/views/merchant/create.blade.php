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
        <h1 class="text-2xl font-bold text-blue-900 mb-6">Create Merchant Profile</h1>

        @if(session('success'))
            <div class="bg-green-500 text-white p-4 mb-4 rounded-lg">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('merchant.store') }}" method="POST">
            @csrf

            <!-- Merchant Name -->
            <div class="mb-4">
                <label for="name" class="block text-gray-700 font-semibold mb-2">Merchant Name:</label>
                <input type="text" name="name" id="name" value="{{ old('name') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Merchant Name">
                @error('name')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Phone -->
            <div class="mb-4">
                <label for="phone" class="block text-gray-700 font-semibold mb-2">Phone:</label>
                <input type="text" name="phone" id="phone" value="{{ old('phone') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Phone Number">
                @error('phone')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-gray-700 font-semibold mb-2">Email:</label>
                <input type="email" name="email" id="email" value="{{ old('email') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Email Address">
                @error('email')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Password -->
            <div class="mb-4">
                <label for="password" class="block text-gray-700 font-semibold mb-2">Password:</label>
                <input type="password" name="password" id="password" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Password">
                @error('password')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Confirm Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Confirm Password:</label>
                <input type="password" name="password_confirmation" id="password_confirmation" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Confirm Password">
                @error('password_confirmation')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Address -->
            <div class="mb-4">
                <label for="address" class="block text-gray-700 font-semibold mb-2">Address:</label>
                <input type="text" name="address" id="address" value="{{ old('address') }}" 
                    class="w-full px-4 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-indigo-500 focus:border-indigo-500" placeholder="Enter Address">
                @error('address')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <!-- Submit Button -->
            <button type="submit" class="w-full text-white bg-blue-500 hover:bg-blue-700 py-2 px-4 rounded-md font-semibold focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                Create Merchant
            </button>
        </form>
    </div>
@endsection
