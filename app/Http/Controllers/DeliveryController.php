<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class DeliveryController extends Controller
{
    public function verifyCode(Request $request)
    {
        $order = Order::find($request->order_id);
    
        if (!$order) {
            return response()->json(['success' => false, 'message' => 'Order not found'], 404);
        }
    
        if ($order->verification_code === $request->verification_code) {
            // Update the order status to Success
            $order->status = 'Success';
            $order->save();
    
            return response()->json(['success' => true, 'message' => 'Code verified']);
        }
    
        return response()->json(['success' => false, 'message' => 'Invalid verification code'], 400);
    }
    
}
