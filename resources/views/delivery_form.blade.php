<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    
    <title>Delivery Form</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-gray-100 py-10">
    @if (auth()->check())
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

        <!-- Wallet Information Card -->
        <div class="bg-green-500 p-4 rounded shadow mb-6 transition duration-300 hover:bg-green-600">
            <h2 class="text-xl font-semibold text-white">Wallet Amount</h2>
            <p class="text-lg text-white"><b>{{ number_format(auth()->user()->wallet->balance, 2) }} FCFA</b></p>
            <a href="{{ route('wallet.transaction.form') }}" class="bg-white text-green-600 font-semibold py-2 px-4 rounded mt-2 inline-block hover:bg-gray-100 transition duration-300">Gérer mon portefeuille</a>
        </div>

       
        
    @else
        <h1 class="text-3xl font-bold mb-4">Bienvenue, invité!</h1>
        <p class="mb-4">Veuillez vous connecter pour accéder à votre tableau de bord.</p>
    @endif

    <div class="max-w-4xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-semibold mb-4">Place a Delivery</h1>

        <form action="{{ route('orders.store') }}" method="POST">
            @csrf 

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
                <!-- Sender Fields -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender's Full Name</label>
                    <input type="text" name="sender_name" placeholder="ex: EYOUM ATOCK J-J Bryan" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender Phone Number</label>
                    <input type="text" name="sender_phone" placeholder="+237" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender Country</label>
                    <select id="sender-country" name="sender_country" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country}}">{{ $country}}</option>
                    @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender Town</label>
                    <select id="sender-town" name="sender_town" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        <option value="">Select Town</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Sender Quarter</label>
                    <select id="sender-quarter" name="sender_quarter" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        <option value="">Select Quarter</option>
                    </select>
                </div>
                <p>Latitude: <span id="sender-lat">N/A</span></p>
    <p>Longitude: <span id="sender-lng">N/A</span></p>
                <!-- Receiver Fields -->
                <div>
                    <label class="block text-sm font-medium text-gray-700">Receiver Name</label>
                    <input type="text" name="receiver_name" placeholder="ex: Isaac Louis Vuiton" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Receiver Phone Number</label>
                    <input type="text" name="receiver_phone" placeholder="+237" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Receiver Country</label>
                    <select id="receiver-country" name="receiver_country" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        <option value="">Select Country</option>
                        @foreach ($countries as $country)
                        <option value="{{ $country}}">{{ $country}}</option>
                    @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Receiver Town</label>
                    <select id="receiver-town" name="receiver_town" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        <option value="">Select Town</option>
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Receiver Quarter</label>
                    <select id="receiver-quarter" name="receiver_quarter" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                        <option value="">Select Quarter</option>
                    </select>
                </div>
                <p>Latitude: <span id="receiver-lat">N/A</span></p>
    <p>Longitude: <span id="receiver-lng">N/A</span></p><!-- Product Information -->
                <div>
                    <h2 class="block text-sm font-medium text-gray-700">Product Information</h2>
                    <div class="bg-gray-100 p-4 rounded-md">
                        <h3 class="text-lg font-semibold">{{ $product->name }}</h3>
                        <p class="font-bold">Price: {{ $product->price }} FCFA</p>
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_price" value="{{ $product->price }}">
                        <input type="hidden" name="merchant_id" value="{{ $product->merchant_id }}">
                        <input type="hidden" name="category_id" value="{{ $product->category_id }}">
                    </div>
                </div>

                <!-- Payment Information -->
                <div>
                    <label for="total_price">Total Price:</label>
                    <span id="total_price">0 FCFA</span>
                </div>
                
                <div>
                    <label class="block text-sm font-medium text-gray-700">Payment Number</label>
                    <input type="text" name="payment_number" placeholder="Enter your payment number" class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2" required>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="payment" value="mtn" class="mr-2" id="mtn" required>
                    <label for="mtn" class="text-sm font-medium text-gray-700">MTN MOBILE MONEY</label>
                </div>
                <div class="flex items-center">
                    <input type="radio" name="payment" value="orange" class="mr-2" id="orange" required>
                    <label for="orange" class="text-sm font-medium text-gray-700">ORANGE MONEY</label>
                </div>
            </div>

            <button type="submit" class="mt-4 w-full bg-blue-600 text-white font-semibold py-2 px-4 rounded-md hover:bg-blue-700">Place Delivery</button>
            @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

        </form>
    </div>

   
<script>
function calculateDistance(lat1, lon1, lat2, lon2) {
    const R = 6371; // Radius of the Earth in km
    const dLat = (lat2 - lat1) * (Math.PI / 180);
    const dLon = (lon2 - lon1) * (Math.PI / 180);
    const a = Math.sin(dLat / 2) * Math.sin(dLat / 2) +
              Math.cos(lat1 * (Math.PI / 180)) * Math.cos(lat2 * (Math.PI / 180)) *
              Math.sin(dLon / 2) * Math.sin(dLon / 2);
    const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
    return R * c; // Distance in km
}

// Calculate the total price based on distance and product price
function calculateTotalPrice() {
    const productPrice = parseFloat($('input[name="product_price"]').val());
    const senderLat = parseFloat($('#sender-lat').text());
    const senderLng = parseFloat($('#sender-lng').text());
    const receiverLat = parseFloat($('#receiver-lat').text());
    const receiverLng = parseFloat($('#receiver-lng').text());

    if (!isNaN(senderLat) && !isNaN(senderLng) && !isNaN(receiverLat) && !isNaN(receiverLng)) {
        const distance = calculateDistance(senderLat, senderLng, receiverLat, receiverLng);
        const deliveryCost = Math.ceil(distance) * 450; // 750 FCFA per km
        const totalPrice = productPrice + deliveryCost;

        $('#total_price').text(totalPrice + ' FCFA'); // Display total price formatted to two decimal places
    } else {
        $('#total_price').text('N/A');
    }
}

// Event listeners to calculate total price when inputs change
$('#sender-lat, #sender-lng, #receiver-lat, #receiver-lng').on('input', calculateTotalPrice);
$('input[name="product_price"]').on('change', calculateTotalPrice);

// Fetch towns when a sender country is selected
$('#sender-country').on('change', function() {
    var senderCountry = $(this).val();  // Updated variable name for sender country
    $.ajax({
        url: '/get-towns/' + senderCountry,
        type: 'GET',
        success: function(response) {
            var senderTownSelect = $('#sender-town');  // Updated variable name for sender town
            senderTownSelect.empty(); // Clear previous options
            senderTownSelect.append('<option value="">Select Town</option>');

            // Add new towns
            $.each(response.towns, function(index, town) {
                senderTownSelect.append('<option value="' + town + '">' + town + '</option>');
            });
        }
    });
});

// Fetch quarters when a sender town is selected
$('#sender-town').on('change', function() {
    var senderTown = $(this).val();  // Updated variable name for sender town
    $.ajax({
        url: '/get-quarters/' + senderTown,
        type: 'GET',
        success: function(response) {
            var senderQuarterSelect = $('#sender-quarter');  // Updated variable name for sender quarter
            senderQuarterSelect.empty(); // Clear previous options
            senderQuarterSelect.append('<option value="">Select Quarter</option>');

            // Add new quarters
            $.each(response.quarters, function(index, quarter) {
                senderQuarterSelect.append('<option value="' + quarter.quarter + '" data-latitude="' + quarter.latitude + '" data-longitude="' + quarter.longitude + '">' + quarter.quarter + '</option>');
            });
        }
    });
});

// Update sender latitude and longitude when the sender quarter is selected
$('#sender-quarter').on('change', function() {
    const selectedOption = $(this).find(':selected');
    const latitude = selectedOption.data('latitude');
    const longitude = selectedOption.data('longitude');

    // Update the display elements
    if (latitude && longitude) {
        $('#sender-lat').text(latitude);
        $('#sender-lng').text(longitude);
        calculateTotalPrice(); // Calculate total price after updating sender's location
    } else {
        $('#sender-lat').text('N/A');
        $('#sender-lng').text('N/A');
        $('#total_price').text('N/A');
    }
});

// Fetch towns when a receiver country is selected
$('#receiver-country').on('change', function() {
    var receiverCountry = $(this).val();  // Updated variable name for receiver country
    $.ajax({
        url: '/get-towns/' + receiverCountry,
        type: 'GET',
        success: function(response) {
            var receiverTownSelect = $('#receiver-town');  // Updated variable name for receiver town
            receiverTownSelect.empty(); // Clear previous options
            receiverTownSelect.append('<option value="">Select Town</option>');

            // Add new towns
            $.each(response.towns, function(index, town) {
                receiverTownSelect.append('<option value="' + town + '">' + town + '</option>');
            });
        }
    });
});

// Fetch quarters when a receiver town is selected
$('#receiver-town').on('change', function() {
    var receiverTown = $(this).val();  // Updated variable name for receiver town
    $.ajax({
        url: '/get-quarters/' + receiverTown,
        type: 'GET',
        success: function(response) {
            var receiverQuarterSelect = $('#receiver-quarter');  // Updated variable name for receiver quarter
            receiverQuarterSelect.empty().append('<option value="">Select Quarter</option>');

            // Loop through the returned 'quarters' array and append options
            $.each(response.quarters, function(index, quarter) {
                receiverQuarterSelect.append('<option value="' + quarter.quarter + '" data-latitude="' + quarter.latitude + '" data-longitude="' + quarter.longitude + '">' + quarter.quarter + '</option>');
            });
        },
        error: function() {
            console.error('Error fetching quarters.');
        }
    });
});

// Update receiver latitude and longitude when the receiver quarter is selected
$('#receiver-quarter').on('change', function() {
    const selectedOption = $(this).find(':selected');
    const latitude = selectedOption.data('latitude');
    const longitude = selectedOption.data('longitude');

    // Update the display elements
    if (latitude && longitude) {
        $('#receiver-lat').text(latitude);
        $('#receiver-lng').text(longitude);
        calculateTotalPrice(); // Calculate total price after updating receiver's location
    } else {
        $('#receiver-lat').text('N/A');
        $('#receiver-lng').text('N/A');
        $('#total_price').text('N/A');
    }
});
</script>

</body>
</html>