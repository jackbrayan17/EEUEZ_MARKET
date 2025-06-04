<?php

namespace App\Http\Controllers;

use App\Models\Storekeeper;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\UserCredentialsMail;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Log; // Log facade for logging errors

class StorekeeperController extends Controller
{
    public function index()
    {
        $storekeepers = Storekeeper::with('user')->get();
        return view('admin.storekeepers.index', compact('storekeepers'));
    }
    public function dashboard(){
        return view('storekeeper.dashboard');
        
    }
    public function create()
    {
        return view('admin.storekeepers.create');
    }

    // Store new storekeeper
    public function store(Request $request)
    {
        // Validate the form data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:4|confirmed',
            'id_number' => 'required|string|max:50',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        // // Output any validation errors
        // if ($validated->fails()) {
        //     // Dump validation errors for debugging
        //     dd($validated->errors());
        // }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'storekeeper',  // Setting the role as 'merchant'
        ]);
        $storekeeper = Storekeeper::create([
            
            'user_id' => $user->id,
            'id_number' => $request->id_number,
            'name' => $request->name,
            'availability' => $request->availability,   
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);
        $user->wallet()->create([
            'balance' => 0.00,  // Initial balance
        ]);
        $roleId = Role::where('name', 'Storekeeper')->first()->id;

        // Insert manually into the model_has_roles table
        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,                // The ID of the 'Merchant' role
            'model_id' => $user->id,             // The ID of the user
            'model_type' => 'App\Models\User',   // The model type (usually 'App\Models\User')
        ]);
       
        Mail::to($user->email)->send(new UserCredentialsMail($user, $request->password));
        return redirect()->route('admin.storekeepers.index')->with('success', 'Storekeeper deleted successfully.');
       
    
    }

    // Edit a storekeeper
    public function edit(Storekeeper $storekeeper)
    {
        return view('admin.storekeepers.edit', compact('storekeeper'));
    }

    // Update a storekeeper
    public function update(Request $request, Storekeeper $storekeeper)
    {
        $request->validate([
            'id_number' => 'required|string|max:50|unique:storekeepers,id_number,' . $storekeeper->id,
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        $storekeeper->update($request->all());

        return redirect()->route('admin.storekeepers.index')->with('success', 'Storekeeper updated successfully.');
    }

    // Delete a storekeeper
    public function destroy(Storekeeper $storekeeper)
    {
        $storekeeper->delete();
        return redirect()->route('admin.storekeepers.index')->with('success', 'Storekeeper deleted successfully.');
    }
}
