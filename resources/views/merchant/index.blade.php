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
    <div class="container mx-auto p-6">
        <h1 class="text-2xl font-bold text-blue-900 mb-6">Merchants List</h1>

        @if($merchants->isEmpty())
            <p class="text-gray-600">No merchants available.</p>
        @else
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white border border-gray-200">
                    <thead class="bg-gray-100">
                        <tr>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">ID</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">Name</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">Phone</th>
                            <th class="py-3 px-6 text-left text-xs font-medium text-gray-700 uppercase tracking-wider border">Address</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($merchants as $merchant)
                            <tr>
                                <td class="py-2 px-4 border text-sm text-gray-700">{{ $merchant->id }}</td>
                                <td class="py-2 px-4 border text-sm text-gray-700">{{ $merchant->name }}</td>
                                <td class="py-2 px-4 border text-sm text-gray-700">{{ $merchant->phone }}</td>
                                <td class="py-2 px-4 border text-sm text-gray-700">{{ $merchant->address }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @endif
    </div>
@endsection
