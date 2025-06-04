<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Storefront;
class StorefrontController extends Controller
{
    public function show($id)
    {
        $storefront = Storefront::with('products')->findOrFail($id);
        return view('merchant.storefront.show', compact('storefront'));
    }
}
