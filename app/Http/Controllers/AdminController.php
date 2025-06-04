<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Spatie\Permission\Models\Role; // Import Spatie Role model
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // Function to show the form for creating a new admin
    public function createForm()
    {
        return view('admin.create'); // This will render the 'admin.create' view
    }

    public function index()
    {
        $users = User::where('created_by', auth()->id())
                    ->role(['Courier', 'Storekeeper'])
                    ->get();
    
        return view('admin.dashboard', compact('users'));
    }
    
    // Function to create a new admin and assign the 'Admin' role using direct DB insertion
    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:4|confirmed',
        ]);

        // Create the user
        // Create the user
$admin = User::create([
    'name' => $request->name,
    'email' => $request->email,
    'phone' => $request->phone,
    'password' => $request->password,
    'created_by' => auth()->id(), // Link to the admin who created
]);


        // Ensure the 'Admin' role exists
        $role = Role::firstOrCreate(
            ['name' => 'Admin'],
            ['guard_name' => 'web'] // Adjust the guard_name if using a different guard
        );

        // Directly insert into the model_has_roles table
        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_id' => $admin->id,
            'model_type' => 'App\Models\User',  // Explicitly specify the model type
        ]);

        // Redirect to the dashboard with a success message
        return redirect()->route('admin.dashboard')->with('success', 'Admin created successfully');
    }
}
