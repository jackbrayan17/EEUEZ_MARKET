<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-900 flex items-center justify-center min-h-screen">

    <div class="bg-white max-w-md w-full p-8 rounded-lg shadow-lg">
        <!-- Card Title with Icon -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-2">
                <!-- Icon -->
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
          
                <h2 class="text-2xl font-bold text-blue-900">Login</h2>
            </div>
        </div>

        <!-- Login Form -->
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            @csrf

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>

            <!-- Password Field -->
            <div class="mb-6">
                <label for="password" class="block text-sm font-semibold text-gray-700">Mot de Passe</label>
                <input type="password" name="password" id="password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>
            
            <!-- Hidden Fields for Geolocation -->
            <input type="hidden" name="longitude" id="longitude">
            <input type="hidden" name="latitude" id="latitude">
            <input type="hidden" name="address_name" id="address_name">

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-emerald-600 text-white py-2 px-4 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                    Login
                </button>
            </div>
        </form>

        <!-- Register Link -->
        <p class="mt-6 text-center text-gray-600">
            Register as a client: <a href="{{ route('client.register.form') }}"
                class="text-emerald-600 hover:underline">Register</a>
        </p>
    </div>

    <!-- Geolocation Script -->
    <script>
        document.getElementById('loginForm').addEventListener('submit', function(event) {
            event.preventDefault(); // Prevent default form submission

            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(function(position) {
                    const longitude = position.coords.longitude;
                    const latitude = position.coords.latitude;

                    // Set the hidden fields with geolocation data
                    document.getElementById('longitude').value = longitude;
                    document.getElementById('latitude').value = latitude;

                    // Get address name using reverse geocoding
                    fetch(`https://nominatim.openstreetmap.org/reverse?lat=${latitude}&lon=${longitude}&format=json`)
                        .then(response => response.json())
                        .then(data => {
                            const address = data.display_name || "Unknown Address"; // Fallback if address not found
                            document.getElementById('address_name').value = address;

                            // Submit the form with all data
                            event.target.submit();
                        })
                        .catch(error => {
                            console.error('Error fetching the address:', error);
                            alert("Could not retrieve the address. Submitting without address.");
                            // Still submit the form without address name
                            event.target.submit();
                        });
                }, function(error) {
                    console.error('Error in geolocation:', error);
                    alert("Geolocation failed. Submitting without geolocation data.");
                    // Submit the form even if geolocation fails
                    event.target.submit();
                });
            } else {
                alert("Geolocation is not supported by this browser.");
                // Still submit the form without geolocation
                event.target.submit();
            }
        });
    </script>
</body>

</html>
