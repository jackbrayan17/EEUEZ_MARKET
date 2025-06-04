@extends('layout.app')

@section('content')
<div class="container mx-auto p-6">
    @if (auth()->check())
    <header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
        <!-- AZ Logo on the Left -->
        <div class="flex items-center">
            <a href="/courier/dashboard"> 
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
            </a>
        </div>

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
             <!-- Display Address Names -->
    
            <form method="POST" action="{{ route('logout') }}" class="ml-4">
                @csrf
                <button type="submit" class="text-red-500 hover:text-red-700">Déconnexion</button>
            </form>
        </div>
    </header>
    @endif
    <div class="bg-white p-4 rounded-lg shadow">
        <h3 class="text-lg font-semibold mb-2">Your Addresses:</h3>
        <ul class="list-disc pl-5">
            @if (session('addresses'))
            <p>{{ session('addresses')->address_name }} </p>
            @else
                <li>No addresses found.</li>
            @endif
        </ul>
    </div>
    <h2 class="text-xl font-semibold mb-4">Tableau de Bord du Livreur</h2>

    <!-- Pending Orders Section -->
    <h3 class="text-lg font-semibold mb-2">Commandes en Attente</h3>
    @if($pendingOrders->isEmpty())
        <p class="text-gray-600">Aucune commande en attente trouvée.</p>
    @else
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID de Commande</th>
                    <th class="border border-gray-300 px-4 py-2">Nom de l'Expéditeur</th>
                    <th class="border border-gray-300 px-4 py-2">Ville de l'Expéditeur</th>
                    <th class="border border-gray-300 px-4 py-2">Quartier de l'Expéditeur</th>
                    <th class="border border-gray-300 px-4 py-2">Nom du Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Ville du Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Quartier du Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Nom du Produit</th>
                    <th class="border border-gray-300 px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($pendingOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $order->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_town ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_quarter ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_town ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_quarter ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->product_info ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('courier.orders.track', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Track</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Delivered Orders Section -->
    <h3 class="text-lg font-semibold mb-2 mt-6">Commandes Livrées</h3>
    @if($deliveredOrders->isEmpty())
        <p class="text-gray-600">Aucune commande livrée trouvée.</p>
    @else
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID de Commande</th>
                    {{-- <th class="border border-gray-300 px-4 py-2">Marchand</th> --}}
                    <th class="border border-gray-300 px-4 py-2">Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Statut</th>
                </tr>
            </thead>
            <tbody>
                @foreach($deliveredOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $order->id }}</td>
                        {{-- <td class="border border-gray-300 px-4 py-2">{{ $order->merchant->name }}</td> --}}
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->status }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- Transit Orders Section -->
    <h3 class="text-lg font-semibold mb-2 mt-6">Commandes en Transit</h3>
    @if($TransitOrders->isEmpty())
        <p class="text-gray-600">Aucune commande en transit trouvée.</p>
    @else
        <table class="min-w-full border border-gray-300">
            <thead class="bg-gray-100">
                <tr>
                    <th class="border border-gray-300 px-4 py-2">ID de Commande</th>
                    <th class="border border-gray-300 px-4 py-2">Nom de l'Expéditeur</th>
                    <th class="border border-gray-300 px-4 py-2">Ville de l'Expéditeur</th>
                    <th class="border border-gray-300 px-4 py-2">Quartier de l'Expéditeur</th>
                    <th class="border border-gray-300 px-4 py-2">Nom du Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Ville du Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Quartier du Destinataire</th>
                    <th class="border border-gray-300 px-4 py-2">Nom du Produit</th>
                    <th class="border border-gray-300 px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($TransitOrders as $order)
                    <tr class="hover:bg-gray-50">
                        <td class="border border-gray-300 px-4 py-2">{{ $order->id }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_town ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->sender_quarter ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_name }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_town ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_quarter ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">{{ $order->product_info ?? 'N/A' }}</td>
                        <td class="border border-gray-300 px-4 py-2">
                            <a href="{{ route('courier.orders.track', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition">Suivre</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(function(position) {
                const longitude = position.coords.longitude;
                const latitude = position.coords.latitude;

                // You might want a reverse geocoding service to get the address name
                const addressName = "Your Address"; // Placeholder for address

                // Send the geolocation data to the backend upon login
                fetch('/login', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}' // Include CSRF token for security
                    },
                    body: JSON.stringify({
                        longitude: longitude,
                        latitude: latitude,
                        address_name: addressName
                    })
                });
            });
        } else {
            alert("Geolocation is not supported by this browser.");
        }
    });
</script>
@endsection
