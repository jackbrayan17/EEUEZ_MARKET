<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User; // Import the User model

class ProfileController extends Controller
{
    // Show the client's profile
    public function index()
    {
        $user = auth()->user(); // Get the logged-in user
        return view('client.profile', compact('user'));
    }

    // Update the client's profile
    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . auth()->id(),
            'phone' => 'required|string|max:15',
        ]);

        $user = auth()->user();
        $user->update($request->only('name', 'email', 'phone'));

        return redirect()->route('client.profile')->with('success', 'Profil mis à jour avec succès.');
    }
}
