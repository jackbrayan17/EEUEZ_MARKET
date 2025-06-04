@extends('layout.app')

@section('content')
@if (auth()->check())
<header class="flex items-center justify-between bg-gray-100 p-4 rounded-lg shadow mb-6">
    <div class="flex items-center">
        <a href="/courier/dashboard">
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
@endif

<div id="map" style="height: 500px;"></div>

<div id="courier-info" class="mt-4">
    <h2 class="text-lg font-semibold">Courier Current Position</h2>
    <p id="address-name" class="text-sm">Address: N/A</p>
    <p id="coordinates" class="text-sm">Coordinates: N/A</p>
</div>
<div class="mt-8 text-center">
    <button id="endDeliveryBtn" class="bg-emerald-600 text-white py-2 px-4 rounded-lg hover:bg-emerald-700 focus:outline-none">
        End Delivery
    </button>
</div>

<!-- Modal -->
<div id="verificationModal" class="fixed inset-0 bg-gray-600 bg-opacity-50 flex items-center justify-center hidden">
    <form action="{{ route('verify.code', ['orderId' => $order->id]) }}" method="POST">
        @csrf
        <div class="mb-4">
            <label for="verification_code" class="block text-sm font-medium text-gray-700">Verification Code</label>
            <input type="text" name="verification_code" id="verification_code" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm" required>
        </div>
    
        <div class="mt-4">
            <button type="submit" class="px-4 py-2 bg-indigo-600 text-white rounded-md hover:bg-indigo-700">Verify Code</button>
        </div>
    </form>
     
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />

<script>
      const endDeliveryBtn = document.getElementById('endDeliveryBtn');
    const verificationModal = document.getElementById('verificationModal');
    const closeModalBtn = document.getElementById('closeModalBtn');
    const submitCodeBtn = document.getElementById('submitCodeBtn');
    const errorMessage = document.getElementById('errorMessage');

    endDeliveryBtn.addEventListener('click', function () {
        verificationModal.classList.remove('hidden');
    });

    closeModalBtn.addEventListener('click', function () {
        verificationModal.classList.add('hidden');
        errorMessage.classList.add('hidden'); // Hide error message when modal is closed
    });

    submitCodeBtn.addEventListener('click', function () {
    const verificationCode = document.getElementById('verificationCodeInput').value;

    // Send AJAX request to verify the code
    fetch(`/verify-code`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
        },
        body: JSON.stringify({
            verification_code: verificationCode,
            order_id: '{{ $order->id }}' // Ensure $order is passed correctly from the backend
        }),
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Error verifying code');
        }
        return response.json(); // Parse JSON response
    })
    .then(data => {
        if (data.status === 'success') {
            alert('Verification successful');
            window.location.href = '/courier/dashboard'; // Redirect to dashboard
        } else {
            alert('Invalid verification code');
        }
    })
    .catch(error => {
        console.error('Error verifying code:', error);
        alert('An error occurred. Please try again.');
    });
});

    const apiKey = '5b3ce3597851110001cf6248c656d902329a4797a48fa15e350c1834';
    let courierCoordinates = [0, 0];
    let senderCoordinates = [{{ $senderLatitude }}, {{ $senderLongitude }}];
    let receiverCoordinates = [{{ $receiverLatitude }}, {{ $receiverLongitude }}];
    let routeLine;
    
    const map = L.map('map').setView(senderCoordinates, 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        maxZoom: 19,
        attribution: '© OpenStreetMap'
    }).addTo(map);

    const courierMarker = L.marker(courierCoordinates).addTo(map).bindPopup('Courier');
    const senderMarker = L.marker(senderCoordinates).addTo(map).bindPopup('Sender');
    const receiverMarker = L.marker(receiverCoordinates).addTo(map).bindPopup('Receiver');

    function drawRoute(startCoords, endCoords) {
        const routeUrl = `https://api.openrouteservice.org/v2/directions/driving-car?api_key=${apiKey}&start=${startCoords[1]},${startCoords[0]}&end=${endCoords[1]},${endCoords[0]}`;
        
        fetch(routeUrl)
            .then(response => response.json())
            .then(data => {
                if (routeLine) {
                    map.removeLayer(routeLine);
                }

                const routeCoords = data.features[0].geometry.coordinates.map(coord => [coord[1], coord[0]]);
                routeLine = L.polyline(routeCoords, { color: 'blue' }).addTo(map);
                map.fitBounds(routeLine.getBounds());
            })
            .catch(err => console.error('Error drawing route:', err));
    }

    senderMarker.on('click', function () {
        drawRoute(courierCoordinates, senderCoordinates);
    });

    receiverMarker.on('click', function () {
        drawRoute(senderCoordinates, receiverCoordinates);
    });

    function saveCourierLocation(latitude, longitude, addressName) {
        fetch(`/courier/location`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
            },
            body: JSON.stringify({
                latitude: latitude,
                longitude: longitude,
                address_name: addressName,
            }),
        })
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
        })
        .catch(err => console.error('Error saving location:', err));
    }

    function getCurrentLocation() {
        if (navigator.geolocation) {
            navigator.geolocation.getCurrentPosition(
                position => {
                    courierCoordinates = [position.coords.latitude, position.coords.longitude];
                    courierMarker.setLatLng(courierCoordinates);
                    map.panTo(courierCoordinates);

                    updateCourierInfo(courierCoordinates[0], courierCoordinates[1]);
                },
                error => {
                    console.error('Error fetching location:', error);
                    alert('Unable to fetch courier location');
                }
            );
        } else {
            console.error('Geolocation is not supported by this browser.');
        }
    }

    function updateCourierInfo(latitude, longitude) {
        document.getElementById('coordinates').innerText = `Coordinates: ${latitude}, ${longitude}`;
        fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
            .then(response => response.json())
            .then(data => {
                const addressName = data.display_name || 'Unknown Address';
                document.getElementById('address-name').innerText = `Address: ${addressName}`;
                
                saveCourierLocation(latitude, longitude, addressName);
            })
            .catch(err => console.error('Error fetching address:', err));
    }

    getCurrentLocation();
    setInterval(getCurrentLocation, 5000); // Update location every 5 seconds
</script>
@endsection
