<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourierAddress;
use App\Models\Courier;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class LoginController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login');
    }

    // Handle the login logic
    public function login(Request $request)
    {
        // Validate the login request
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // Retrieve the credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt to log the user in
        if (Auth::attempt($credentials)) {
            // Get the authenticated user
            $user = Auth::user();

            // Log the user's details for debugging
            Log::info('User logged in:', ['user_id' => $user->id, 'email' => $user->email, 'roles' => $user->getRoleNames()]);

            // Redirect the user based on their role
            if ($user->hasRole('Super Admin')) {
                return redirect()->route('superadmin.dashboard')->with('success', 'Welcome Super Admin!');
            } elseif ($user->hasRole('Admin')) {
                return redirect()->route('admin.dashboard')->with('success', 'Welcome Admin!');
            } elseif ($user->hasRole('Courier')) {
                $longitude = $request->input('longitude');
                $latitude = $request->input('latitude');
                $addressName = $request->input('address_name');
                $courier = Courier::where('name', $user->name)->firstOrFail();
    
                CourierAddress::create([
                        'courier_id' => $courier->id,
                        'longitude' => $longitude,
                        'latitude' => $latitude,
                        'address_name' => $addressName,
                ]
                );
                $addresses = $courier->addresses()->latest()->first(); // Assuming the relationship is defined
                session(['addresses' => $addresses]);
                return redirect()->route('courier.dashboard')->with([
                    'success' => 'Welcome Courier!',
                    'addresses' => $addresses,
                ]);
               } elseif ($user->hasRole('Courier')) {
                return redirect()->route('courier.dashboard')->with('success', 'Welcome Courier!');
            } elseif ($user->hasRole('Merchant Client')) {  // Merchant Client upgrade case
                return redirect()->route('merchant.dashboard')->with('success', 'Welcome to the Merchant Dashboard!');
            } elseif ($user->hasRole('Client')) {
                return redirect()->route('client.dashboard')->with('success', 'Welcome Client!');
            } else {
                Auth::logout(); // Optional: Log out if no roles
                return redirect()->route('login')->withErrors(['error' => 'Your account does not have a valid role. Please contact support.']);
            }
        }

        // If authentication failed, return with an error message
        return redirect()->back()->withErrors(['error' => 'Invalid credentials. Please try again.']);
    }

    // Handle user logout
    public function logout(Request $request)
    {
        Auth::logout();
        return redirect()->route('login')->with('success', 'You have been logged out.');
    }
}
