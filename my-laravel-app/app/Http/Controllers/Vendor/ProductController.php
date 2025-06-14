<?php

namespace App\Http\Controllers\Vendor;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * Display a listing of the vendor's products.
     */
    public function index(Request $request)
    {
        $vendor = Auth::user();
        
        // Get products with pagination
        $products = Product::where('vendor_id', $vendor->id)
            ->when($request->search, function ($query, $search) {
                return $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('category', 'like', "%{$search}%");
                });
            })
            ->when($request->status, function ($query, $status) {
                return $query->where('status', $status);
            })
            ->when($request->category, function ($query, $category) {
                return $query->where('category', $category);
            })
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        // Calculate stats
        $allProducts = Product::where('vendor_id', $vendor->id);
        
        $stats = [
            'total' => $allProducts->count(),
            'active' => $allProducts->where('status', 'active')->count(),
            'pending' => $allProducts->where('status', 'pending')->count(),
            'inactive' => $allProducts->where('status', 'inactive')->count(),
            'total_revenue' => $this->calculateTotalRevenue($vendor->id),
        ];

        return view('vendor.products.index', compact('products', 'stats'));
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        $categories = $this->getProductCategories();
        return view('vendor.products.create', compact('categories'));
    }

    /**
     * Store a newly created product in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'product_type' => 'required|in:digital,physical,service',
            'price' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0|max:100',
            'sales_page_url' => 'nullable|url',
            'resources_page_url' => 'nullable|url',
            'thankyou_page_url' => 'nullable|url',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
        ]);

        $validated['vendor_id'] = Auth::id();
        $validated['status'] = 'pending'; // Default status for new products
        $validated['slug'] = Str::slug($validated['name']);

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            $validated['featured_image'] = $request->file('featured_image')
                ->store('products', 'public');
        }

        // Handle tags
        if ($request->tags) {
            $validated['tags'] = json_encode(
                array_map('trim', explode(',', $request->tags))
            );
        }

        $product = Product::create($validated);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product created successfully! It will be reviewed before going live.');
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        // Ensure vendor can only view their own products
        if ($product->vendor_id !== Auth::id()) {
            abort(404);
        }

        // Format product data for JSON response
        $productData = [
            'id' => $product->id,
            'name' => $product->name,
            'description' => $product->description,
            'category' => $product->category,
            'category_display_name' => $product->getCategoryDisplayName(),
            'product_type' => $product->product_type,
            'type_icon' => $product->getTypeIcon(),
            'price' => $product->price,
            'formatted_price' => $product->getFormattedPrice(),
            'commission' => $product->commission,
            'status' => $product->status,
            'sales_page_url' => $product->sales_page_url,
            'resources_page_url' => $product->resources_page_url,
            'thankyou_page_url' => $product->thankyou_page_url,
            'meta_title' => $product->meta_title,
            'meta_description' => $product->meta_description,
            'tags_array' => $product->tags ? json_decode($product->tags) : [],
            'created_at' => $product->created_at->toISOString(),
            'updated_at' => $product->updated_at->toISOString(),
        ];

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'product' => $productData
            ]);
        }

        return view('vendor.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        // Ensure vendor can only edit their own products
        if ($product->vendor_id !== Auth::id()) {
            abort(404);
        }

        $categories = $this->getProductCategories();
        return view('vendor.products.edit', compact('product', 'categories'));
    }

    /**
     * Update the specified product in storage.
     */
    public function update(Request $request, Product $product)
    {
        // Ensure vendor can only update their own products
        if ($product->vendor_id !== Auth::id()) {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category' => 'required|string|max:100',
            'product_type' => 'required|in:digital,physical,service',
            'price' => 'required|numeric|min:0',
            'commission' => 'required|numeric|min:0|max:100',
            'sales_page_url' => 'nullable|url',
            'resources_page_url' => 'nullable|url',
            'thankyou_page_url' => 'nullable|url',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:255',
            'tags' => 'nullable|string',
        ]);

        $validated['slug'] = Str::slug($validated['name']);

        // Handle file upload
        if ($request->hasFile('featured_image')) {
            // Delete old image if exists
            if ($product->featured_image) {
                Storage::disk('public')->delete($product->featured_image);
            }
            
            $validated['featured_image'] = $request->file('featured_image')
                ->store('products', 'public');
        }

        // Handle tags
        if ($request->tags) {
            $validated['tags'] = json_encode(
                array_map('trim', explode(',', $request->tags))
            );
        } else {
            $validated['tags'] = null;
        }

        $product->update($validated);

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product updated successfully!');
    }

    /**
     * Remove the specified product from storage.
     */
    public function destroy(Product $product)
    {
        // Ensure vendor can only delete their own products
        if ($product->vendor_id !== Auth::id()) {
            if (request()->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthorized'
                ], 403);
            }
            abort(404);
        }

        // Delete associated image if exists
        if ($product->featured_image) {
            Storage::disk('public')->delete($product->featured_image);
        }

        $product->delete();

        if (request()->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully!'
            ]);
        }

        return redirect()
            ->route('vendor.products.index')
            ->with('success', 'Product deleted successfully!');
    }

    /**
     * Get vendor stats (for AJAX requests)
     */
    public function stats()
    {
        $vendor = Auth::user();
        $allProducts = Product::where('vendor_id', $vendor->id);
        
        $stats = [
            'total' => $allProducts->count(),
            'active' => $allProducts->where('status', 'active')->count(),
            'pending' => $allProducts->where('status', 'pending')->count(),
            'inactive' => $allProducts->where('status', 'inactive')->count(),
            'total_revenue' => $this->calculateTotalRevenue($vendor->id),
        ];

        return response()->json([
            'success' => true,
            'stats' => $stats
        ]);
    }

    /**
     * Export products to CSV
     */
    public function export()
    {
        $vendor = Auth::user();
        $products = Product::where('vendor_id', $vendor->id)->get();

        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="products_' . date('Y-m-d') . '.csv"',
        ];

        $callback = function() use ($products) {
            $file = fopen('php://output', 'w');
            
            // CSV headers
            fputcsv($file, [
                'ID', 'Name', 'Category', 'Type', 'Price', 'Commission', 
                'Status', 'Created', 'Sales Page', 'Resources Page'
            ]);

            // CSV data
            foreach ($products as $product) {
                fputcsv($file, [
                    $product->id,
                    $product->name,
                    $product->category,
                    $product->product_type,
                    $product->price,
                    $product->commission . '%',
                    $product->status,
                    $product->created_at->format('Y-m-d'),
                    $product->sales_page_url ?: 'N/A',
                    $product->resources_page_url ?: 'N/A',
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    /**
     * Calculate total revenue for vendor
     */
    private function calculateTotalRevenue($vendorId)
    {
        // This would typically come from a sales/orders table
        // For now, returning 0 as placeholder
        return 0;
        
        // Example implementation:
        // return Order::whereHas('product', function($query) use ($vendorId) {
        //     $query->where('vendor_id', $vendorId);
        // })->where('status', 'completed')->sum('total_amount');
    }

    /**
     * Get available product categories
     */
    private function getProductCategories()
    {
        return [
            'electronics' => 'Electronics',
            'clothing' => 'Clothing & Fashion',
            'home-garden' => 'Home & Garden',
            'health-beauty' => 'Health & Beauty',
            'sports-outdoors' => 'Sports & Outdoors',
            'toys-games' => 'Toys & Games',
            'books-media' => 'Books & Media',
            'automotive' => 'Automotive',
            'jewelry' => 'Jewelry & Accessories',
            'food-beverages' => 'Food & Beverages',
            'software' => 'Software & Apps',
            'courses' => 'Online Courses',
            'ebooks' => 'E-books',
            'templates' => 'Templates & Themes',
            'services' => 'Professional Services',
            'consulting' => 'Consulting',
            'other' => 'Other'
        ];
    }
}