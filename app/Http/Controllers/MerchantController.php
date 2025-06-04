<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Merchant;
use App\Models\User;
use App\Models\Order;
use App\Models\Storefront; // Assume you have a Storefront model
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role; 
use Illuminate\Support\Facades\Auth;

class MerchantController extends Controller
{
    public function showOrdersForMerchant()
{
    $merchant = Auth::user(); // or use specific authentication for merchant

    $orders = Order::whereHas('product', function ($query) use ($merchant) {
        $query->where('merchant_id', $merchant->id);
    })->get();

    return view('merchant.orders.show', compact('orders'));
}

    public function storefronts()
{
    $merchant = Auth::user()->merchant;

    if ($merchant) {
        // Fetch the storefronts that belong to the merchant
        $storefronts = Storefront::where('merchant_id', $merchant->id)->withCount('products')->get();
        $storefrontCount = $storefronts->count();
    } else {
        $storefronts = [];
        $storefrontCount = 0;
    }

    $premiumAccess = Auth::user()->premium_access ?? 0;

    return view('merchant.storefronts', compact('storefrontCount', 'storefronts', 'premiumAccess'));
}

public function viewStorefront($id)
{
    $storefront = Storefront::with('products')->findOrFail($id);
    return view('merchant.view_storefront', compact('storefront'));
}

public function addProductPage($id)
{
    $storefront = Storefront::findOrFail($id);
    return view('merchant.add_product', compact('storefront'));
}


    public function createStorefront(Request $request)
    {
    // Validate the input
    $request->validate([
        'name' => 'required|string|max:255',
        'category' => 'required|string|max:255',
    ]);

    // Create the storefront
    Storefront::create([
        'merchant_id' => Auth::user()->merchant->id,
        'name' => $request->name,
        'category' => $request->category,
    ]);

    return redirect()->route('merchant.storefronts')->with('success', 'Storefront created successfully.');
}

public function createProduct(Request $request)
{
    // Validate the input
    $request->validate([
        'storefront_id' => 'required|exists:storefronts,id',
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric',
        'stock' => 'required|integer|min:0',
    ]);

    // Create the product
    Product::create([
        'user_id' => Auth::id(), // Assuming the product belongs to the authenticated user
        'category_id' => $request->category_id, // Make sure to pass the category ID
        'name' => $request->name,
        'description' => $request->description,
        'price' => $request->price,
        'stock' => $request->stock,
    ]);

    return redirect()->route('merchant.storefronts')->with('success', 'Product added successfully.');
}

    public function dashboard()
    {
        $merchant = auth()->user();  // Assuming the user is authenticated as a merchant
        $orders = Order::where('merchant_id', $merchant->id)->get();

        return view('merchant.dashboard', compact('orders'));
}

    public function merchantstorefronts()
    {
        return view('merchant.storefronts'); // Create a view for the merchant dashboard
    }

    public function storefrontCreatepage()
    {
        return view('merchant.storefront.create');
    }
    public function create()
    {
        return view('merchant.create');
    }
    public function trackOrder($orderId)
    {
        $order = Order::findOrFail($orderId);
        $senderQuarter = $order->sender_quarter; // Assuming this is stored in the Order model
        $receiverQuarter = $order->receiver_quarter; // Assuming this is stored in the Order model
        $senderAddress = Address::where('quarter', $senderQuarter)->firstOrFail();
        $receiverAddress = Address::where('quarter', $receiverQuarter)->firstOrFail();
        
        // Get the authenticated courier
        $merchant = auth()->user(); // Assuming the courier is linked to the order
    
        return view('merchant.orders.track', [
            'senderLatitude' => $senderAddress->latitude,
            'senderLongitude' => $senderAddress->longitude,
            'receiverLatitude' => $receiverAddress->latitude,
            'receiverLongitude' => $receiverAddress->longitude,
           
        
        ]);
    }
    // Store the new Merchant in the database
    
    public function store(Request $request)
    {
        // Validate the input
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:4|confirmed',
            'address' => 'nullable|string|max:255',
        ]);

        // Create the merchant and associate it with the current user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password, // Ensure password is hashed
            'role' => 'merchant',  // Setting the role as 'merchant'
        ]);

        Merchant::create([
            'user_id' => $user->id,
            'name' => $request->name,
            'phone' => $request->phone,
            'address' => $request->address,
        ]);

        $user->wallet()->create([
            'balance' => 0.00,  // Initial balance
        ]);

        $roleId = Role::where('name', 'Merchant Client')->first()->id;

        // Insert manually into the model_has_roles table
        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,                // The ID of the 'Merchant' role
            'model_id' => $user->id,             // The ID of the user
            'model_type' => 'App\Models\User',   // The model type (usually 'App\Models\User')
        ]);
       
        return redirect()->route('merchant.index')->with('success', 'Merchant account created successfully.');
    }

    public function index()
    {
        $merchants = Merchant::all();
        return view('merchant.index', compact('merchants'));
    }

    // Function to create a storefront
    

    // Function to simulate premium payment access
    public function purchasePremiumAccess(Request $request)
    {
        $request->validate([
            'premium_type' => 'required|string|in:2.5k,5k', // Type of premium access
        ]);

        $merchant = Auth::user()->merchant;

        // Check current premium access level
        if ($merchant->premium_access) {
            return redirect()->back()->with('error', 'You already have premium access.');
        }

        // Simulate the payment process (you can integrate a payment gateway here)
        $amount = $request->premium_type == '2.5k' ? 2500 : 5000;
        // Assuming you have a method to deduct from merchant's wallet
        if ($merchant->wallet->balance < $amount) {
            return redirect()->back()->with('error', 'Insufficient balance for the purchase.');
        }

        // Deduct the payment from the merchant's wallet
        $merchant->wallet->decrement('balance', $amount);

        // Update premium access level
        $merchant->premium_access = $request->premium_type;
        $merchant->save();

        return redirect()->route('merchant.dashboard')->with('success', 'Premium access purchased successfully.');
    }

    // Helper function to determine max storefronts
    private function getMaxStorefronts($premiumAccess)
    {
        switch ($premiumAccess) {
            case '2.5k':
                return 5;
            case '5k':
                return 10;
            default:
                return 2; // Default number of storefronts
        }
    }
}
