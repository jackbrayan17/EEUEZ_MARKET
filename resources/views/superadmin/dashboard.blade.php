

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    
    <title>Super Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <header class="bg-blue-900 p-4">
        <div class="container mx-auto flex justify-between items-center">
            <!-- Logo on the left -->
            <div class="flex items-center">
                <img src="{{ asset('AZ_fastlogo.png') }}" alt="Logo" class="h-10 w-auto mr-4">
                <span class="text-white text-xl font-semibold">Super Admin Dashboard</span>
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
    <!-- Main Content -->
    <div class="container mx-auto mt-10 px-4">
        <h1 class="text-3xl font-bold text-blue-900 mb-6">Welcome to the Super Admin Dashboard</h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            <!-- Add Admin Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">Add Admin</h2>
                <p class="text-gray-600 mb-4">Create a new admin to help manage the system.</p>
                <a href="{{ route('admin.create.form') }}"
                    class="text-white bg-emerald-600 hover:bg-emerald-700 py-2 px-4 rounded-lg">
                    Add Admin
                </a>
            </div>

            <!-- Add Merchant Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">Add Merchant</h2>
                <p class="text-gray-600 mb-4">Create a merchant account to allow product management.</p>
                <a href="{{ route('admin.merchant.create') }}"
                    class="text-white bg-emerald-600 hover:bg-emerald-700 py-2 px-4 rounded-lg">
                    Add Merchant
                </a>
            </div>

            <!-- List of Merchants Card -->
            <div class="bg-white shadow-md rounded-lg p-6">
                <h2 class="text-xl font-semibold text-blue-900 mb-2">List of Merchants</h2>
                <p class="text-gray-600 mb-4">View all registered merchants in the system.</p>
                <a href="{{ route('merchant.index') }}"
                    class="text-white bg-emerald-600 hover:bg-emerald-700 py-2 px-4 rounded-lg">
                    View Merchants
                </a>
            </div>

            <!-- Additional dashboard content -->
        </div>
    </div>

</body>

</html>

