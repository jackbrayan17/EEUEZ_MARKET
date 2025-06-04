<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SupportController extends Controller
{
    // Show the support page
    public function index()
    {
        return view('client.support.index'); // Adjust the view name as needed
    }

    // Handle support requests (example function)
    public function submit(Request $request)
    {
        $request->validate([
            'message' => 'required|string|max:500',
        ]);

        // Logic to handle support messages (e.g., storing in the database or sending an email)

        return redirect()->route('client.support')->with('success', 'Votre message a été envoyé avec succès.');
    }
}

