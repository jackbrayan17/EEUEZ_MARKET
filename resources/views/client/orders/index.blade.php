@extends('layout.app')

@section('content')
<div class="container mx-auto p-4">
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
    <h2 class="text-2xl font-semibold mb-4">Mes Commandes</h2>

    @if($orders->isEmpty())
        <p class="text-gray-600">Vous n'avez pas encore de commandes.</p>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full border border-gray-300 bg-white shadow rounded-lg">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border border-gray-300 px-4 py-2 text-left">ID de Commande</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Infos Produit</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Quartier Expéditeur</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Quartier Destinataire</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Code de Commande</th> 
                        <th class="border border-gray-300 px-4 py-2 text-left">Statut</th>
                        <th class="border border-gray-300 px-4 py-2 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orders as $order)
                        <tr class="hover:bg-gray-50 transition-colors">
                            <td class="border border-gray-300 px-4 py-2">{{ $order->id }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->product_info }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->sender_quarter ?? 'N/A' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->receiver_quarter ?? 'N/A' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->verification_code ?? 'N/A' }}</td>
                            <td class="border border-gray-300 px-4 py-2">{{ $order->status }}</td>
                            <td class="border border-gray-300 px-4 py-2">
                                @if($order->status === 'In Transit')
                                    <a href="{{ route('client.orders.track', $order->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600 transition duration-300">Suivre la Commande</a>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection
