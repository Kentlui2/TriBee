<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Services\ProductService;
use App\Modules\Products\Models\Product;
use App\Modules\Products\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\View\View;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function __construct(
        protected ProductService $productService
    ) {}

    // Storefront: Displays the catalog index with pagination.
    // Managed by: Member 1 Billiones (Frontend Catalog)
    public function AdminIndex(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        // 🌟 SECURITY CHECK: Prevent Admins from accessing the User panel view layout
        // Fixed: Uses 'is_admin == 1' to perfectly match the column name in phpMyAdmin
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect('/admin/products');
        }

        // 1. Fetch all categories so your brand-new sidebar can render them immediately
        $categories = Category::all();

        // 2. Start query with inventory relations eager loaded to prevent undefined attributes
        $query = Product::with(['inventory', 'category']);

        // 3. Handle Sidebar Department Filtering
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->input('category_id'));
        }

        // 4. 🔍 ADVANCED SEARCH LOGIC: Now checks Name, Brand, Description, AND Category Name!
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                // Search regular product text attributes
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('brand', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  
                  //  Cross-reference and search by the category's name field
                  ->orWhereHas('category', function($categoryQuery) use ($searchTerm) {
                      $categoryQuery->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // Filter by specific brand selection
        if ($request->filled('brand')) {
            $query->where('brand', $request->input('brand'));
        }

        // Filter by minimum price boundary
        if ($request->filled('min_price')) {
            $query->where('price', '>=', $request->input('min_price'));
        }

        // Filter by maximum price boundary
        if ($request->filled('max_price')) {
            $query->where('price', '<=', $request->input('max_price'));
        }

        // Filter by explicit average product performance/review rating
        if ($request->filled('rating')) {
            $query->where('rating', '>=', $request->input('rating'));
        }

        // 5. Fetch the filtered products matrix
        $products = $query->paginate(12);
        
        // 6. Return the layout view utilizing your Module's explicit namespace
        return view('products.catalog.index', compact('products', 'categories'))
            ->with('filters', $request->all());
    }

    // Combined Search and Filter Action (Handles the /catalog/search route seamlessly)
    public function search(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        return $this->AdminIndex($request);
    }

    // Storefront: Displays individual product details.
    // Managed by: Member 1 Billiones (Frontend Catalog)
    public function show(int $id): View
    {
        $product = Product::with('inventory')->findOrFail($id);
        
        return view('products.show', compact('product'));
    }

    public function adminDashboard(): View
    {
        // Eager load the products and stock quantities for the management grid
        $products = Product::with('inventory')->get();

        // Renders the dedicated admin file from your module view path
        return view('products.admin', compact('products'));
    }

    // Admin Panel: Saves a new product via API/Form.
    // Managed by: Member 4 Francis(Admin Inventory API)
    public function store(Request $request): \Illuminate\Http\RedirectResponse
    {
        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:255',
            'brand' => 'required|string',
            'description' => 'required|string',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . time();

        $product = Product::create($validated);
        $product->inventory()->create(['stock' => $validated['stock']]);

        // Redirect to the admin index instead of returning JSON
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product added successfully!');
    }

    // Admin Panel: Updates existing product data.
    // Managed by: Member 4 Francis(Admin Inventory API)
    public function update(Request $request, int $id): \Illuminate\Http\RedirectResponse
    {
        $product = Product::findOrFail($id);

        $validated = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name'        => 'required|string|max:255',
            'brand'       => 'required|string',
            'description' => 'required|string',
            'price'       => 'required|numeric|min:0',
            'stock'       => 'required|integer|min:0',
        ]);

        $product->update([
            'category_id' => $validated['category_id'],
            'name'        => $validated['name'],
            'brand'       => $validated['brand'],
            'description' => $validated['description'],
            'price'       => $validated['price'],
        ]);

        if ($product->inventory) {
            $product->inventory->update(['stock' => $validated['stock']]);
        } else {
            $product->inventory()->create(['stock' => $validated['stock']]);
        }

        // Redirect to the admin index with a success message
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product updated successfully!');
    }

    //Admin Panel: Removes product from system.
    // Managed by: Member 4 Francis(Admin Inventory API)
    public function destroy(int $id): \Illuminate\Http\RedirectResponse
    {
        $product = Product::findOrFail($id);
        $product->delete();
        
        // Redirect back to the admin page after the item is gone
        return redirect()->route('admin.products.index')
                         ->with('success', 'Product deleted successfully!');
    }

    // Admin Panel: Shows the form to create a new product.
    // Managed by: Member 4 (Admin Inventory API)
    public function create(): \Illuminate\View\View
    {
        // Fetch categories so the admin can choose one from a dropdown select menu
        $categories = Category::all();
        
        return view('products.create', compact('categories'));
    }

    // Admin Panel: Shows the form to edit an existing product.
    // Managed by: Member 4 (Admin Inventory API)
    public function edit(int $id): \Illuminate\View\View
    {
        $product = Product::with('inventory')->findOrFail($id);
        $categories = Category::all();
        
        return view('products.edit', compact('product', 'categories'));
    }

    /**
     * Fallback wrapper method to intercept dashboard hits and handle routing roles
     * entirely inside our own workspace boundary.
     */
    public function index(Request $request): View|\Illuminate\Http\RedirectResponse
    {
        // 🌟 FORCE ADMINS TO THEIR OWN PANEL ONLY
        // Fixed: Uses 'is_admin == 1' to perfectly match the column name in phpMyAdmin
        if (Auth::check() && Auth::user()->is_admin == 1) {
            return redirect('/admin/products');
        }

        // Regular users drop straight down into your public web catalog layout
        return $this->AdminIndex($request);
    }
}