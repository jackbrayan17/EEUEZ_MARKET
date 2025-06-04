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

    <h2 class="text-3xl font-bold text-gray-800 mb-6">Admin Dashboard</h2>
    <p class="text-gray-600 mb-4">Bienvenue, {{ auth()->user()->name }}!</p>

    <div class="flex flex-col md:flex-row gap-4 mb-6">
        <a href="{{ route('admin.couriers.create') }}" class="w-full md:w-auto bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">
            Add Courier
        </a>
        <a href="{{ route('admin.storekeepers.create') }}" class="w-full md:w-auto bg-green-500 text-white px-4 py-2 rounded hover:bg-green-600 transition">
            Add Storekeeper
        </a>
    </div>

    <!-- Manage Users -->
    <div class="mt-8">
        <h3 class="text-xl font-semibold text-gray-800 mb-4">Manage Users</h3>

        <div class="overflow-x-auto">
            <table class="table-auto w-full text-left border-collapse">
                <thead>
                    <tr class="bg-gray-200 text-gray-600 uppercase text-sm leading-normal">
                        <th class="py-3 px-6">#</th>
                        <th class="py-3 px-6">Name</th>
                        <th class="py-3 px-6">Role</th>
                        <th class="py-3 px-6">Email</th>
                        <th class="py-3 px-6">Phone</th>
                        <th class="py-3 px-6">Actions</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700 text-sm font-light">
                    @foreach($users as $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-100">
                        <td class="py-3 px-6">{{ $loop->iteration }}</td>
                        <td class="py-3 px-6">{{ $user->name }}</td>
                        <td class="py-3 px-6">{{ implode(', ', $user->roles->pluck('name')->toArray()) }}</td>
                        <td class="py-3 px-6">{{ $user->email }}</td>
                        <td class="py-3 px-6">{{ $user->phone }}</td>
                        <td class="py-3 px-6">
                            <div class="flex items-center space-x-4">
                                <a href="{{ route('admin.couriers.edit', $user->id) }}" class="text-blue-500 hover:underline">Edit</a>
                                <form action="{{ route('admin.couriers.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Are you sure you want to delete this user?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-500 hover:underline">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
