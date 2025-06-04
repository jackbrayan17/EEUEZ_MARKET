@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Order Tracking</h1>

        <!-- Leaflet Map Container -->
        <div id="map" style="height: 500px;"></div>

        <!-- Display the Distance Information -->
        <p id="distance"></p>

        <!-- End Delivery Button (For Courier) -->
        @if(auth()->user()->role === 'courier' && $order->status === 'in_transit')
            <form action="{{ route('courier.verification', $order->id) }}" method="GET">
                <button type="submit" class="btn btn-primary">End Delivery</button>
            </form>
        @endif

        <!-- Cancel Delivery Button (For Client) -->
        @if(auth()->user()->role === 'client' && $order->status === 'in_transit')
            <form action="{{ route('cancel-delivery', $order->id) }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Cancel Delivery</button>
            </form>
        @endif
    </div>

    <script>
        // Initialize the map and set its view to the courier's location
        var courierLat = {{ $courier->latitude }};
        var courierLng = {{ $courier->longitude }};
        var destinationLat = {{ $order->destination_lat }};
        var destinationLng = {{ $order->destination_long }};

        var map = L.map('map').setView([courierLat, courierLng], 13);

        // Add OpenStreetMap tiles to the map
        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors'
        }).addTo(map);

        // Add markers for the courier and the destination
        var courierMarker = L.marker([courierLat, courierLng]).addTo(map)
            .bindPopup('Courier Location').openPopup();

        var destinationMarker = L.marker([destinationLat, destinationLng]).addTo(map)
            .bindPopup('Delivery Destination').openPopup();

        // Function to calculate the distance between two coordinates (in kilometers)
        function calculateDistance(lat1, lon1, lat2, lon2) {
            const R = 6371; // Radius of the Earth in km
            const dLat = (lat2 - lat1) * Math.PI / 180;
            const dLon = (lon2 - lon1) * Math.PI / 180;
            const a =
                0.5 - Math.cos(dLat) / 2 +
                Math.cos(lat1 * Math.PI / 180) * Math.cos(lat2 * Math.PI / 180) *
                (1 - Math.cos(dLon)) / 2;

            return R * 2 * Math.asin(Math.sqrt(a));
        }

        // Calculate and display the distance between the courier and the destination
        var distance = calculateDistance(courierLat, courierLng, destinationLat, destinationLng).toFixed(2);
        document.getElementById('distance').innerHTML = 'Distance between courier and destination: ' + distance + ' km';

        // Real-time tracking (polling every 5 seconds)
        setInterval(() => {
            fetch('{{ route('get.courier.location', $courier->id) }}')
                .then(response => response.json())
                .then(data => {
                    var newLat = data.latitude;
                    var newLng = data.longitude;

                    // Update the courier's marker location
                    courierMarker.setLatLng([newLat, newLng]);

                    // Recalculate the distance
                    var newDistance = calculateDistance(newLat, newLng, destinationLat, destinationLng).toFixed(2);
                    document.getElementById('distance').innerHTML = 'Distance between courier and destination: ' + newDistance + ' km';
                });
        }, 5000); // 5 seconds
    </script>
@endsection
