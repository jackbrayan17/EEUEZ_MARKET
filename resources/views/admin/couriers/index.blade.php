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
                {{-- <li><a href="{{ route('admin.couriers.index') }}" class="hover:underline">Manage Couriers</a></li> --}}
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
    <h1 class="text-2xl font-bold mb-4">Manage Couriers</h1>
    <a href="{{ route('admin.couriers.create') }}" class="mb-4 inline-block bg-blue-500 text-white font-bold py-2 px-4 rounded hover:bg-blue-600">Add New Courier</a>

    <div class="overflow-x-auto bg-white shadow-md rounded-lg">
        <table class="min-w-full divide-y divide-gray-200">
            <thead class="bg-gray-100">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">#</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Phone</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">ID Number</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-gray-200">
                @foreach($couriers as $courier)
                <tr>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $courier->id }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $courier->user->name }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $courier->user->email }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $courier->user->phone }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">{{ $courier->id_number }}</td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                        <a href="{{ route('admin.couriers.edit', $courier->id) }}" class="text-yellow-500 hover:text-yellow-700">Edit</a>
                        <form action="{{ route('admin.couriers.destroy', $courier->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-500 hover:text-red-700 ml-2">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
