<?php 
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\ProductImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // List all products for the Merchant Client or Admin
    public function index()
    {
        $user = Auth::user();
        if ($user->hasRole('Admin')) {
            $products = Product::with('category', 'images')->get();
        } elseif ($user->hasRole('Merchant Client')) {
            $products = Product::with('category', 'images')->where('user_id', $user->id)->get();
        }

        return view('products.index', compact('products'));
    }

    // Show form to create a product
    public function create($storefrontId)
    {
       // $this->authorize('create', Product::class);

        $categories = Category::all(); // Get all categories
       
        return view('products.create', compact('categories', 'storefrontId'));

    }

    // Store a new product in the database
   public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Added webp, increased max size (adjust as needed)
            'storefront_id' => 'required|exists:storefronts,id',
            'merchant_id' => 'required|exists:merchants,id',
        ]);

        // Create the product
        $product = Product::create([
            'user_id' => Auth::id(),
            'name' => $request->name,
            'description' => $request->description,
            'price' => $request->price,
            'stock' => $request->stock,
            'storefront_id' => $request->storefront_id,
            'merchant_id' => $request->merchant_id,
            'category_id' => $request->category_id,
        ]);

        // Handle image uploads to Supabase Storage
        if ($request->hasFile('images')) {
            $index = 1; // Initialize an index for naming unique files
            foreach ($request->file('images') as $image) {
                // Generate a unique file name and path within the Supabase bucket
                $extension = $image->getClientOriginalExtension();
                // Example: my_product_name_timestamp_random.jpg
                $imageName = strtolower(str_replace(' ', '_', $product->name)) . '_' . time() . '_' . uniqid() . '.' . $extension;
                $filePath = 'products/' . $product->id . '/' . $imageName; // Store images in a product-specific subfolder

                try {
                    // Upload the image to Supabase Storage
                    // file_get_contents($image->getRealPath()) reads the file into memory
                    Storage::disk('supabase')->put($filePath, file_get_contents($image->getRealPath()), [
                        'public' => true, // Ensure public access if your bucket is public
                        'contentType' => $image->getClientMimeType(), // Set correct MIME type
                    ]);

                    // Get the public URL of the uploaded image
                    $publicUrl = Storage::disk('supabase')->url($filePath);

                    // Create a record in your product_images table
                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $publicUrl, // Save the full public URL
                    ]);

                } catch (\Exception $e) {
                    // Log the error for debugging
                    \Log::error("Failed to upload image to Supabase for product {$product->id}: " . $e->getMessage());
                    // Optionally, return an error message to the user
                    return back()->with('error', 'One or more images failed to upload. Please try again.');
                }
                $index++; // Increment the index, though timestamp/uniqid handles uniqueness better
            }
        }

        return redirect()->route('storefronts.show', $request->storefront_id)
            ->with('success', 'Product created successfully with images!');
    }
    // Show form to edit a product
    public function edit(Product $product)
    {
        $this->authorize('update', $product);
        $categories = Category::all(); // Get all categories
        return view('products.edit', compact('product', 'categories'));
    }
// Show a specific product
public function show(Product $product)
{
    // Load the category and images for the product
    $product->load('category', 'images');

    return view('products.show', compact('product'));
}

    // Update an existing product in the database
    public function update(Request $request, Product $product)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,webp|max:2048', // Added webp
            // No storefront_id or merchant_id validation needed if they aren't updated here
        ]);

        // Update product details
        $product->update($request->except(['images', 'delete_images'])); // Exclude image fields from direct update

        // Handle image deletion if requested
        if ($request->has('delete_images') && is_array($request->delete_images)) {
            foreach ($request->delete_images as $imageId) {
                $image = ProductImage::find($imageId);
                if ($image) {
                    try {
                        // Extract the path from the URL to delete from Supabase Storage
                        // Example: "https://your-bucket.supabase.co/storage/v1/object/public/products/123/image.jpg"
                        // becomes "products/123/image.jpg"
                        $pathToDelete = str_replace(Storage::disk('supabase')->url(''), '', $image->image_path);

                        // Delete from Supabase Storage
                        Storage::disk('supabase')->delete($pathToDelete);

                        // Delete the record from your database
                        $image->delete();

                    } catch (\Exception $e) {
                        \Log::error("Failed to delete image from Supabase Storage for ProductImage ID {$imageId}: " . $e->getMessage());
                        // Consider informing the user, but don't halt the update process
                    }
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $extension = $image->getClientOriginalExtension();
                $imageName = strtolower(str_replace(' ', '_', $product->name)) . '_' . time() . '_' . uniqid() . '.' . $extension;
                $filePath = 'products/' . $product->id . '/' . $imageName; // Store images in a product-specific subfolder

                try {
                    Storage::disk('supabase')->put($filePath, file_get_contents($image->getRealPath()), [
                        'public' => true,
                        'contentType' => $image->getClientMimeType(),
                    ]);

                    $publicUrl = Storage::disk('supabase')->url($filePath);

                    ProductImage::create([
                        'product_id' => $product->id,
                        'image_path' => $publicUrl, // Save the full public URL
                    ]);

                } catch (\Exception $e) {
                    \Log::error("Failed to upload new image to Supabase for product {$product->id}: " . $e->getMessage());
                    return back()->with('error', 'One or more new images failed to upload. Please try again.');
                }
            }
        }

        return redirect()->route('products.index')->with('success', 'Product updated successfully!');
    }

    

    // Delete a product
    public function destroy(Product $product)
    {
        // Delete associated images from Supabase Storage first
        foreach ($product->images as $image) { // Assuming a 'images' relationship on your Product model
            try {
                $pathToDelete = str_replace(Storage::disk('supabase')->url(''), '', $image->image_path);
                Storage::disk('supabase')->delete($pathToDelete);
            } catch (\Exception $e) {
                \Log::error("Failed to delete image from Supabase during product destroy for URL: {$image->image_path}. Error: " . $e->getMessage());
                // Don't stop product deletion if image deletion fails, but log it
            }
        }

        // Delete the product itself (this will also cascade delete ProductImage records if set up)
        $product->delete();

        return redirect()->route('products.index')->with('success', 'Product and associated images deleted successfully!');
    }
}
