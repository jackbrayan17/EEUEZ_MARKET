<?php 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Models\Courier;

use App\Models\Delivery;
use App\Models\Merchant;
use App\Models\Product; 
use App\Models\Address; 
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    
    
    // Display the delivery form for clients only
    public function display($productId)
    {
        // Ensure the authenticated user is a client
        $user = Auth::user();
        if (!$user || !$user->hasRole('Client')) {
            return redirect()->route('home')->with('error', 'You do not have permission to access this page.');
        }
        $countries = Address::select('country')->distinct()->get()->pluck('country');
        $product = Product::findOrFail($productId);
        return view('delivery_form', compact('product','countries'));
        
    }

    // Handle form submission for creating a new order
    public function store(Request $request)
    {
        // Validate the incoming request
        $request->validate([
            'sender_name' => 'required|string|max:255',
            'sender_phone' => 'required|string|max:20',
            'sender_town' => 'required|string|max:100',
            'sender_quarter' => 'required|string|max:100',
            'receiver_name' => 'required|string|max:255',
            'receiver_phone' => 'required|string|max:20',
            'receiver_town' => 'required|string|max:100',
            'receiver_quarter' => 'required|string|max:100',
            'product_id' => 'required|exists:products,id',
            'category_id' => 'required|exists:categories,id',
            'product_price' => 'required|numeric|exists:products,price',
            'payment' => 'required|string',
            'payment_number' => 'required|string',
            'merchant_id' => 'required|integer|exists:merchants,id',
        ]);
        $verificationCode = strtoupper(Str::random(7)); // Generates a random 7-character alphanumeric string

        // Create sender address
        // $senderAddress = Address::create([
        //     'country' => $request->sender_country, // Add this field in your form
        //     'town' => $request->sender_town,
        //     'quarter' => $request->sender_quarter,
        // ]);
    
        // // Create receiver address
        // $receiverAddress = Address::create([
        //     'country' => $request->receiver_country, // Add this field in your form
        //     'town' => $request->receiver_town,
        //     'quarter' => $request->receiver_quarter,
        // ]);
    
        // Store the order in the database with a default status of 'Pending'
        $order = Order::create([
            'sender_name' => $request->sender_name,
            'sender_phone' => $request->sender_phone,
            'sender_town' => $request->sender_town,
            'sender_quarter' => $request->sender_quarter,
            'receiver_name' => $request->receiver_name,
            'receiver_phone' => $request->receiver_phone,
            'receiver_town' => $request->receiver_town,
            'receiver_quarter' => $request->receiver_quarter,
            'product_info' => Product::findOrFail($request->product_id)->name,
            'category' => $request->category_id,
            'price' => $request->product_price,
            'payment_number' => $request->payment_number,
            'payment' => $request->payment,
            'status' => 'Pending', // Set status to Pending by default
            'client_id' => Auth::id(),
            'verification_code' => $verificationCode,
            'merchant_id' => $request->merchant_id,
        ]);
    
        return redirect()->route('client.orders.index')->with('success', 'Order placed successfully and is pending.');
    }
    
    public function verificationPage($orderId)
    {
        $order = Order::findOrFail($orderId);
    
        // Ensure only the assigned courier can access this page
        if (auth()->id() !== $order->courier_id) {
            abort(403, 'Unauthorized access.');
        }
    
        return view('courier.verification', [
            'order' => $order,
        ]);
    }
    
    public function verifyCode(Request $request, $orderId)
    {
        // Validate the form input
        $request->validate([
            'verification_code' => 'required|string|max:7',
        ]);
    
        // Find the order based on the ID
        $order = Order::findOrFail($orderId);
        $courier = Courier::where('name', auth()->user()->name)->firstOrFail();

        // Ensure only the assigned courier can access this
        // if (auth()->id() !== $order->courier_id) {
        //     abort(403, 'Unauthorized access.');
        // }
    
        // Verify the provided verification code
        if ($order->verification_code === $request->verification_code) {
            $order->status = 'Success';
            $order->save();
    
            // Redirect with a success message
            return redirect()->route('courier.dashboard')->with('success', 'Delivery successfully completed.');
        }
    
        // If the code doesn't match, return with an error
        return back()->withErrors(['invalid_code' => 'Invalid verification code. Please try again.']);
    }
    
    public function showDeliveryForm()
    {
        $countries = Country::all();
        return view('delivery_form', compact('countries'));
    }
    

    public function getTowns($country)
    { 
        $towns = Address::where('country', $country)->select('town')->distinct()->get()->pluck('town');
        return response()->json(['towns' => $towns]);
    }

    public function getQuarters($town)
    {
        $quarters = Address::where('town', $town)->select('quarter', 'latitude', 'longitude')->distinct()->get();
        return response()->json(['quarters' => $quarters]);
       }



       public function startDelivery($orderId)
       {
           $order = Order::findOrFail($orderId);
           $courier = auth()->user(); // Get the authenticated courier
           $order->status = 'In Transit';
           $order->save();
           // Create a new delivery record
        //    Delivery::create([
        //        'courier_id' => $courier->id,
        //        'client_id' => $order->client_id, // Assuming orders have a client_id
        //        'merchant_id' => $order->merchant_id,
        //        'order_id' => $order->id,
        //        'status' => 'Pending', // Set initial status to Pending
        //    ]);
       
           // Redirect to the tracking page or wherever needed
           return redirect()->route('track.delivery', $order->id)->with('success', 'Delivery started successfully!');
       }


    public function trackingPage($orderId)
    {
        $order = Order::with(['client', 'courier'])->findOrFail($orderId);
    
        // Check if the user has the right to view this page
        $user = auth()->user();
        if ($user->id !== $order->client_id && $user->id !== $order->courier_id && !$user->isMerchant()) {
            abort(403, 'Unauthorized access.');
        }
    
        // Pass client and courier location to the view
        return view('tracking', [
            'order' => $order,
            'clientLatitude' => $order->client_latitude,
            'clientLongitude' => $order->client_longitude,
            'courierLatitude' => $order->courier_latitude,
            'courierLongitude' => $order->courier_longitude,
        ]);
    }
    

    public function updateCourierLocation(Request $request)
{
    $order = Order::find($request->order_id);
    $order->courier_latitude = $request->latitude;
    $order->courier_longitude = $request->longitude;
    $order->save();

    return response()->json(['status' => 'success']);
}


    // Display the merchant's orders
    public function index()
    {
        $user = Auth::user();
        $orders = $this->getOrdersForUser($user); // Fetch orders based on role
        if (!$orders) {
            $orders = collect(); // Return an empty collection if no orders are found
        }
        
        return view('orders.index', compact('orders'));
    }

    public function indexMerchant()
    {
        $userId = auth()->id();
        $merchant = Merchant::where('user_id', $userId)->first();
        // Find the merchant by the user ID
        $orders = Order::where('merchant_id', $merchant->id)->get();
    
        return view('merchant.orders.index', compact('orders')); // Return the orders view
    }
    

    // Show the details of a specific order
    public function track($id)
    {
        $order = Order::findOrFail($id);
    
        // Assuming you have tracking data available for the order.
        return view('courier.orders.track', compact('order'));
    }
    
    // Show the details of a specific order
   public function show($id)
   {
       try {
           $order = Order::with('products')->findOrFail($id);
           $user = Auth::user();
   
           // Check if the user has permission to view the order
           $this->authorize('view', $order);
   
           // Check user role and display corresponding view
           if ($user->hasRole('Courier')) {
               return view('courier.orders.show', compact('order'));
           } elseif ($user->hasRole('Client')) {
               return view('client.orders.show', compact('order'));
           } elseif ($user->hasRole('Merchant Client')) {
               return view('merchant.orders.show', compact('order'));
           } else {
               return redirect()->route('orders.index')->with('error', 'Unauthorized access.');
           }
       } catch (\Exception $e) {
           return redirect()->route('orders.index')->with('error', 'Order not found.');
       }
   }
   

    // Private method to handle fetching orders based on user role
    private function getOrdersForUser($user)
    {
        if ($user->hasRole('Merchant Client')) {
            return Order::where('merchant_id', $user->id)->with('products')->get();
        } elseif ($user->hasRole('Admin')) {
            return Order::with('products')->get();
        } elseif ($user->hasRole('Client')) {
            // Fetch orders where the authenticated user is the client
            return Order::where('client_id', $user->id)->with('products')->get();
        } else {
            return collect(); // Return an empty collection if no valid role is found
        }
    }
    
}
