@extends('layout.app')

@section('content')
<header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center">
        <a href="/client/dashboard"> 
            <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
        </a>   
    </div>

    <div class="flex items-center ml-auto">
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

<!-- Courier Address Section -->
<div class="mt-6">
    <h2 class="text-2xl font-semibold">Adresse de départ du livreur</h2>
    <p class="text-gray-700"><b>Adresse initiale:</b> {{ $order->courier_address_name ?? 'N/A' }}</p>
</div>

<!-- Map Section -->
<div id="map" class="mt-6" style="height: 500px;"></div>

<!-- Courier Information Section -->
<div id="courier-info" class="mt-4 bg-white shadow-lg rounded-lg p-6">
    <h2 class="text-xl font-semibold mb-2"><b>Position du livreur</b></h2>
    <p id="courier-address-name" class="text-gray-700"><b>Adresse actuelle:</b>  {{ $courierAddressName ?? 'N/A' }}</p>
    {{-- Uncomment if needed --}}
    {{-- <p id="courier-coordinates" class="text-gray-700"><b>Coordonnées:</b> {{ $courierLatitude ?? 'N/A' }}, {{ $courierLongitude ?? 'N/A' }}</p> --}}
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
    const apiKey = '5b3ce3597851110001cf6248c656d902329a4797a48fa15e350c1834';
    let senderCoordinates = [{{ $senderLatitude }}, {{ $senderLongitude }}];
    let receiverCoordinates = [{{ $receiverLatitude }}, {{ $receiverLongitude }}];
    let courierCoordinates = [{{ $courierLatitude ?? 0 }}, {{ $courierLongitude ?? 0 }}]; // Use default 0,0 if undefined
    let routeLine; // Variable to store the route line on the map
    const map = L.map('map').setView(senderCoordinates, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: 'Az fast'
    }).addTo(map);
    const senderMarker = L.marker(senderCoordinates).addTo(map).bindPopup('Expéditeur');
    const receiverMarker = L.marker(receiverCoordinates).addTo(map).bindPopup('Destinataire');
    const courierMarker = L.marker(courierCoordinates).addTo(map).bindPopup('Livreur (Position initiale)');
    document.getElementById('courier-address-name').innerText = `Adresse initiale: {{ $order->courier_address_name ?? 'N/A' }}`;
    function drawRoute(startCoords, endCoords) {
    if (routeLine) {
        map.removeLayer(routeLine); // Remove existing route if it exists
    }
    const url = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${startCoords.join(',')}&end=${endCoords.join(',')}`;
    fetch(url)
        .then(response => response.json())
        .then(data => {
            console.log(data); // Check the structure of the response
            if (data.routes && data.routes.length > 0) {
                const route = data.routes[0]; // Get the first route
                const latlngs = route.geometry.coordinates.map(coord => [coord[1],coord =>  coord[0]]); // Convert to [lat, lng]
                routeLine = L.polyline(latlngs, { color: 'blue', weight: 5 }).addTo(map); // Add the route to the map
                map.fitBounds(routeLine.getBounds()); // Adjust the map to fit the route
            } else {
                console.error('No routes found in the response:', data);
                alert('Unable to find a route. Please check the locations and try again.');
            }
        })
        .catch(error => {
            console.error('Error fetching route:', error);
            alert('Error fetching route. Please try again later.');
        });
}
    senderMarker.on('click', function() {
        

        drawRoute(courierCoordinates, senderCoordinates); // Draw route from sender to receiver
    });

    receiverMarker.on('click', function() {
        drawRoute(senderCoordinates, receiverCoordinates); // Draw route from receiver to sender
    });

</script>
@endsection
