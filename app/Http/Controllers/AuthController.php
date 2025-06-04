<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Courier;
use App\Models\Storekeeper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AuthController extends Controller
{
    
    public function showCourierRegistrationForm()
    {
        return view('auth.courier_register');
    }

    public function registerCourier(Request $request)
    {
        
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:4|confirmed',
            'id_number' => 'required|string|max:50|unique:couriers,id_number',
            'vehicle_brand' => 'required|string|max:255',
            'vehicle_registration_number' => 'required|string|max:255|unique:couriers,vehicle_registration_number',
            'vehicle_color' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);
        dd($request->all());
        if ($validator->fails()) {
           
             return redirect()->back()->withErrors($validator)->withInput();
         }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password, // Hash the password
        ]);

        $role = Role::firstOrCreate(
            ['name' => 'Courier'],
            ['guard_name' => 'web']
        );

        // Create a new courier entry
        $courier = Courier::create([
            'user_id' => $user->id,
            'id_number' => $request->id_number,
            'vehicle_brand' => $request->vehicle_brand,
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'vehicle_color' => $request->vehicle_color,
            'availability' => $request->availability,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_id' => $user->id,
            'model_type' => 'App\Models\User',
        ]);
        Mail::to($user->email)->send(new UserCredentialsMail($user, $request->password));
        // Redirect to KYC form
        return redirect()->route('kyc.form', ['user' => $user->id]);
    }

    public function showStorekeeperRegistrationForm()
    {
        return view('auth.storekeeper_register');
    }

    public function registerStorekeeper(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'phone' => 'required|string|max:15|unique:users,phone',
            'password' => 'required|string|min:4|confirmed',
            'id_number' => 'required|string|max:50|unique:storekeepers,id_number',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        // Handle validation failures
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Create a new user entry for the storekeeper
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password, // Hash the password
        ]);

        $role = Role::firstOrCreate(
            ['name' => 'Storekeeper'],
            ['guard_name' => 'web']
        );

        // Create a new storekeeper entry
        $storekeeper = Storekeeper::create([
            'user_id' => $user->id,
            'id_number' => $request->id_number,
            'availability' => $request->availability,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);

        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_id' => $user->id,
            'model_type' => 'App\Models\User',
        ]);
        Mail::to($user->email)->send(new UserCredentialsMail($user, $request->password));
        // Redirect to KYC form
        return redirect()->route('kyc.form', ['user' => $user->id]);
    }
}
