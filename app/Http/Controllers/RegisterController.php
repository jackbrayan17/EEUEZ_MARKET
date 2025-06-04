<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Models\User;
use App\Models\Client;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register'); // Your form view
    }

    public function register(Request $request)
    {
        // Validate the request
        $validator = Validator::make($request->all(), [
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
            'town' => ['required', 'string', 'max:255'],
            'quarter' => ['required', 'string', 'max:255'],
            'fees' => ['integer'],
            'longitude' => ['nullable', 'numeric'],
            'latitude' => ['nullable', 'numeric'],
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create the user
        $user = User::create([
            'username' => $request->input('username'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
             'role' => 'client', 
        ]);
        $address = Address::create([
            'town' => $request->input('town'),
            'quarter' => $request->input('quarter'),
            'fees' => $request->input('fees', 0),
            'longitude' => $request->input('longitude'),
            'latitude' => $request->input('latitude'),
        ]);
        Client::create([
            'user_id' => $user->id,
            'address_id' => $address->id, // Assuming the address is optional at registration
        ]);

        return redirect()->route('login')->with('success', 'Registration successful!');
    }
}
