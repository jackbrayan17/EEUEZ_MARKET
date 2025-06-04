<?php
namespace App\Http\Controllers;

use App\Models\Courier;
use App\Models\User;
use App\Models\Address;
use App\Models\Role;
use App\Models\Client;
use App\Models\Order;
use App\Models\Delivery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;


class CourierController extends Controller
{
    public function startDelivery($orderId)
    {
        $order = Order::findOrFail($orderId);
        $courier = auth()->user(); // Get the authenticated courier
        $order->status = 'In Transit';
        $order->save();
        // Create a new delivery record
        Delivery::create([
            'courier_id' => $courier->id,
            'client_id' => $order->client_id, // Assuming orders have a client_id
            'merchant_id' => $order->merchant_id,
            'order_id' => $order->id,
            'status' => 'Pending', // Set initial status to Pending
        ]);
    
        // Redirect to the tracking page or wherever needed
        return redirect()->route('courier.deliveries.start', $order->id)->with('success', 'Delivery started successfully!');
    }
    public function verifyCode(Request $request)
{
    // Validate the form input
    $request->validate([
        'verification_code' => 'required|string|max:7',
        'order_id' => 'required|exists:orders,id',
    ]);

    // Find the order based on the ID
    $order = Order::findOrFail($request->order_id);

    // Check if the logged-in user is the courier assigned to this order
    if (auth()->id() !== $order->courier_id) {
        return back()->withErrors(['unauthorized' => 'Unauthorized access to this order']);
    }

    // Verify the provided verification code
    if ($order->verification_code === $request->verification_code) {
        $order->status = 'completed';
        $order->save();

        // Redirect with a success message
        return redirect()->route('courier.dashboard')->with('success', 'Delivery successfully completed');
    }

    // If the code doesn't match, return with an error
    return back()->withErrors(['invalid_code' => 'Invalid verification code. Please try again.']);
}


    public function trackOrder(Request $request, $orderId)
{
    // Retrieve the order and authenticated user
    $order = Order::findOrFail($orderId);
    $user = auth()->user();
    
    // Retrieve the courier by their name (from the authenticated user)
    $courier = Courier::where('name', auth()->user()->name)->firstOrFail();

    // Update the order status to 'In Transit'
    $order->status = 'In Transit';
    
    // Get the courier's latest address
    $courierAddress = $courier->addresses()->latest()->first(); 
    
    // Update order with courier details
    $order->courier_id = $courier->id;
    $order->courier_longitude = $courierAddress->longitude;
    $order->courier_latitude = $courierAddress->latitude;
    $order->courier_address_name = $courierAddress->address_name;

    // Save the updated order
    $order->save();

    // Retrieve sender and receiver addresses based on their quarters
    $senderAddress = Address::where('quarter', $order->sender_quarter)->firstOrFail();
    $receiverAddress = Address::where('quarter', $order->receiver_quarter)->firstOrFail();
    
    // Pass data to the courier's track order view
    return view('courier.orders.track', [
        'order' => $order,
        'senderLatitude' => $senderAddress->latitude,
        'senderLongitude' => $senderAddress->longitude,
        'receiverLatitude' => $receiverAddress->latitude,
        'receiverLongitude' => $receiverAddress->longitude,
        'courierLongitude' => $courierAddress->longitude,
        'courierLatitude' => $courierAddress->latitude,
        'courierAddressName' => $courierAddress->address_name,
    ]);
}

public function updateLocation(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
        ]);
        $courier = Courier::where('name', auth()->user()->name)->firstOrFail();

        $courierId = $courier->id;
        $latitude = $request->latitude;
        $longitude = $request->longitude;

        // Get the address name from reverse geocoding using OpenStreetMap API or other services
        $addressName = $this->getAddressName($latitude, $longitude);

        // Update or create courier location
        CourierAddress::updateOrCreate(
            ['courier_id' => $courierId],
            [
                'latitude' => $latitude,
                'longitude' => $longitude,
                'address_name' => $addressName,
            ]
        );

        return response()->json(['message' => 'Location updated successfully']);
    }

    // Reverse geocoding function to get address name from latitude and longitude
    private function getAddressName($latitude, $longitude)
    {
        $url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json";
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        
        return $data['display_name'] ?? 'Unknown Address';
    }
        public function index()
    { 
        
        $couriers = Courier::with('user')->get();
        return view('admin.couriers.index', compact('couriers'));
    }
    public function dashboard(){
        $courier = auth()->user();
        $pendingOrders = Order::where('status', 'Pending')->get(['id', 'sender_quarter', 'receiver_quarter' ,'sender_town', 'receiver_town','product_info','sender_name', 'receiver_name']);
        $deliveredOrders = Order::where('status', 'Success')->get(['id', 'sender_quarter', 'receiver_quarter','sender_town', 'receiver_town','product_info', 'sender_name', 'receiver_name']);
        $TransitOrders = Order::where('status', 'In Transit')->get(['id', 'sender_quarter', 'receiver_quarter','sender_town', 'receiver_town','product_info', 'sender_name', 'receiver_name']);

        // Pass both variables to the view
        return view('courier.dashboard', compact('TransitOrders','pendingOrders', 'deliveredOrders'));
    }
    public function create()
    {
        // Show form to create a new courier
        return view('admin.couriers.create');
    }
    public function getLocation($id)
    {
        $courier = Courier::findOrFail($id);
    
        return response()->json([
            'latitude' => $courier->latitude,
            'longitude' => $courier->longitude,
        ]);
    }
    
    public function store(Request $request)
    {
        // Validate request data
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

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => $request->password,
            'role' => 'courier',  // Setting the role as 'merchant'
        ]);
       $courier = Courier::create([
            'user_id' => $user->id,
            'id_number' => $request->id_number,
            'name' => $request->name,
            'availability' => $request->availability,   
            'vehicle_registration_number' => $request->vehicle_registration_number,
            'vehicle_color' => $request->vehicle_color,
            'vehicle_brand' => $request->vehicle_brand,
            'city' => $request->city,
            'neighborhood' => $request->neighborhood,
        ]);
        $user->wallet()->create([
            'balance' => 0.00,  // Initial balance
        ]);
        $roleId = Role::where('name', 'Courier')->first()->id;

        // Insert manually into the model_has_roles table
        DB::table('model_has_roles')->insert([
            'role_id' => $roleId,                // The ID of the 'Merchant' role
            'model_id' => $user->id,             // The ID of the user
            'model_type' => 'App\Models\User',   // The model type (usually 'App\Models\User')
        ]);
        return redirect()->route('admin.couriers.index')->with('success', 'Courier saved successfully.');
       }
    // Edit a courier
    public function edit(Courier $courier)
    {
        return view('courier.edit', compact('courier'));
    }

    // Update a courier
    public function update(Request $request, Courier $courier)
    {
        $request->validate([
            'id_number' => 'required|string|max:50|unique:couriers,id_number',
            'vehicle_brand' => 'required|string|max:255',
            'vehicle_registration_number' => 'required|string|max:255|unique:couriers,vehicle_registration_number,'.$courier->id,
            'vehicle_color' => 'required|string|max:255',
            'availability' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'neighborhood' => 'required|string|max:255',
        ]);

        $courier->update($request->all());

        return redirect()->route('admin.couriers.index')->with('success', 'Courier updated successfully.');
    }

    // Delete a courier
    public function destroy(Courier $courier)
    {
        $courier->delete();
        return redirect()->route('admin.couriers.index')->with('success', 'Courier deleted successfully.');
    }
}
