<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;
use App\Models\Address;
use App\Models\Client;
use App\Models\Merchant;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class ClientController extends Controller
{
    public function trackOrder($orderId)
    {
        // Retrieve the order by its ID
        $order = Order::findOrFail($orderId);
    
        // Retrieve sender and receiver addresses
        $senderQuarter = $order->sender_quarter; // Assuming this is stored in the Order model
        $receiverQuarter = $order->receiver_quarter; // Assuming this is stored in the Order model
        $senderAddress = Address::where('quarter', $senderQuarter)->firstOrFail();
        $receiverAddress = Address::where('quarter', $receiverQuarter)->firstOrFail();
    
        // Retrieve the courier for this order
        $courier = $order->courier; // Assuming courier is linked to the order
    
        // Check if the courier is not null
        if (!$courier) {
            // Handle the case where no courier is assigned to the order
            return response()->json(['error' => 'No courier assigned to this order'], 404);
        }
    
        // Retrieve the courier's initial address (the latest one or tied to the order)
        $courierAddressName = $order->courier_address_name;
    
        return view('client.orders.track', [
            'order' => $order,
            'senderLatitude' => $senderAddress->latitude,
            'senderLongitude' => $senderAddress->longitude,
            'receiverLatitude' => $receiverAddress->latitude,
            'receiverLongitude' => $receiverAddress->longitude,
            'courierLatitude' => $order->courier_latitude ?? null,
            'courierLongitude' => $order->courier_longitude ?? null,
            'courierAddressName' => $order->courier_address_name ?? 'N/A'
        ]);
    }
    
    public function showUpgradeForm()
{
    return view('client.upgrade');
}
public function products()
{
    $products = Product::all(); // Fetch all products
    return view('client.products.index', compact('products')); // Return the view with products
}
    public function upgradeToMerchant(Request $request)
    {
        $request->validate([
            'payment_method' => 'required|string',
            'phone' => 'required|string|max:15',
        ]);
        $client = auth()->user();
        $wallet = $client->wallet;

        if (!$wallet || $wallet->balance < 1000) {
            return redirect()->back()->with('error', 'Solde insuffisant dans votre portefeuille pour effectuer cette opération.');
        }
        Merchant::create([
            'user_id' => $client->id,
            'name' => $client->name,
            'phone' => $client->phone,
            'address' => $client->address,
        ]);
        $wallet->balance -= 1000;
        $wallet->save();
        DB::table('model_has_roles')->insert([
            'role_id' => DB::table('roles')->where('name', 'Merchant Client')->value('id'),
            'model_id' => $client->id,
            'model_type' => 'App\Models\User',
        ]);
    
        return redirect()->route('merchant.dashboard')->with('success', 'Vous êtes maintenant un Merchant Client!');
    }
    public function showRegisterForm()
    {
        return view('client.register'); // Assuming the form view is in 'resources/views/client/register.blade.php'
    }
    public function clientOrder(){
        $client = auth()->user();

        // Fetch orders for the authenticated client
        $orders = Order::where('client_id', $client->id)->get(['id','product_info','sender_quarter','receiver_quarter','verification_code','status']);

        return view('client.orders.index', compact('orders'));
     }
    
    public function dashboard()
    {
        $users = User::with('roles')->get();
        return view('client.dashboard', compact('users')); // Assuming you have a 'client/dashboard.blade.php' view
    }
    // Handle client registration
    public function register(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'phone' => 'required|string|max:15',
            'password' => 'required|string|min:4|confirmed',
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        // Create the client (user) record
        $client = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => $request->password,
            'role' => 'client'
        ]);
        $clients = Client::create([
            'user_id' => $client->id,
            // Add any additional fields for the Client model here
        ]);
            if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/profile_images', $fileName, 'public');
    
            // If user already has a profile image, update it
            if ($user->profileImage) {
                // Delete the previous image file if needed
                Storage::disk('public')->delete($user->profileImage->image_path);
    
                // Update the existing image record
                $user->profileImage->update([
                    'image_path' => $filePath,
                ]);
            } else {
                // Create a new profile image if none exists
                $user->profileImage()->create([
                    'image_path' => $filePath,
                ]);
            }
        }

        $client->wallet()->create([
            'balance' => 0.00,  // Initial balance
        ]);
        // Fetch the Client role
        $role = Role::where('name', 'Client')->first();

        // Assign the 'Client' role using DB facade
        DB::table('model_has_roles')->insert([
            'role_id' => $role->id,
            'model_id' => $client->id,
            'model_type' => 'App\Models\User',  // Explicitly specify the model type
        ]);

        // Redirect to a success page or client dashboard
        return redirect()->route('login')->with('success', 'Client registered successfully');
    }
    public function editImage()
    {
        return view('profile.edit');
    }
    public function updateImage(Request $request)
    {
        $request->validate([
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validate image file
        ]);
    
        $user = auth()->user();
    
        // Check if an image is uploaded
        if ($request->hasFile('profile_image')) {
            $file = $request->file('profile_image');
            $fileName = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('uploads/profile_images', $fileName, 'public');
    
            // If user already has a profile image, update it
            if ($user->profileImage) {
                // Delete the previous image file if needed
                Storage::disk('public')->delete($user->profileImage->image_path);
    
                // Update the existing image record
                $user->profileImage->update([
                    'image_path' => $filePath,
                ]);
            } else {
                // Create a new profile image if none exists
                $user->profileImage()->create([
                    'image_path' => $filePath,
                ]);
            }
        }

        return redirect()->route('client.dashboard')->with('success', 'Client registered successfully');
    }
    
    // Display the client dashboard after registration (optional)
   
}
