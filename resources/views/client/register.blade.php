<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Client Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-blue-900 flex items-center justify-center min-h-screen">

    <div class="bg-white max-w-lg w-full p-8 rounded-lg shadow-lg">
        <!-- Card Title with Icon -->
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center space-x-2">
                <!-- Icon -->
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
          
                <h2 class="text-2xl font-bold text-blue-900">S'inscrire</h2>
            </div>
        </div>

        <!-- Registration Form -->
        <form method="POST" action="{{ route('client.register') }}">
            @csrf

            <!-- Name Field -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-semibold text-gray-700">Nom Complet</label>
                <input type="text" name="name" id="name"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>

            <!-- Email Field -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-semibold text-gray-700">Email</label>
                <input type="email" name="email" id="email"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>

            <!-- Phone Field -->
            <div class="mb-4">
                <label for="phone" class="block text-sm font-semibold text-gray-700">Numéro de Téléphone</label>
                <input type="text" name="phone" id="phone"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>

            <!-- Password Field -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-semibold text-gray-700">Mot de Passe</label>
                <input type="password" name="password" id="password"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>

            <!-- Confirm Password Field -->
            <div class="mb-6">
                <label for="password_confirmation"
                    class="block text-sm font-semibold text-gray-700">Confirmation Mot de Passe</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm focus:outline-none focus:ring-emerald-600 focus:border-emerald-600"
                    required>
            </div>

            <!-- Submit Button -->
            <div>
                <button type="submit"
                    class="w-full bg-emerald-600 text-white py-2 px-4 rounded-lg hover:bg-emerald-700 focus:outline-none focus:ring-2 focus:ring-emerald-600 focus:ring-offset-2">
                    S'inscrire
                </button>
            </div>
        </form>

        <!-- Error Messages -->
        @if ($errors->any())
            <div class="mt-6 p-4 bg-red-100 text-red-700 rounded-lg">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Log In Link -->
        <p class="mt-6 text-center text-gray-600">
            Log In: <a href="{{ route('login') }}" class="text-emerald-600 hover:underline">Log In</a>
        </p>
    </div>

</body>

</html>
