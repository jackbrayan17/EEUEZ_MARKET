<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>

    <link rel="icon" href="{{ asset('AZ_fastlogo.png') }}" type="image/png">
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <title>@yield('title', 'AZ Fast')</title>
</head>
<body>
    <style>
        body{
       font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        body a:any-link{
            color: #098857 ;
            text-decoration: none;
        }
    </style>
   
    <main>
        @yield('content')
    </main>
    <footer class="bg-gray-800 text-white mt-10 py-6">
        <div class="max-w-7xl mx-auto px-4">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="text-center md:text-left">
                    <h2 class="text-lg font-semibold">Contact Information</h2>
                    <p class="mt-2">Eyoum Atock J-J Brayan</p>
                    <p class="mt-1">Email: <a href="mailto:its.jackbrayan17@gmail.com" class="text-blue-400 hover:underline">its.jackbrayan17@gmail.com</a></p>
                    <p class="mt-1">Phone: <a href="tel:+237657757036" class="text-blue-400 hover:underline">+237 657 757 036</a></p>
                </div>
                <div class="mt-4 md:mt-0">
                    <p class="text-sm">&copy;2025 Eyoum Atock J-J Brayan. All rights reserved.</p>
                </div>
            </div>
        </div>
    </footer>
    
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>    
    
</body>
</html>
