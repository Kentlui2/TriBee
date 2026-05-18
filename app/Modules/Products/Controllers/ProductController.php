<?php

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Services\ProductService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Exception;

class ProductController extends Controller
{
    /**
     * PHP 8.2 Constructor Promotion
     */
    public function __construct(
        private readonly ProductService $productService
    ) {}

    /**
     * Display the Frontend Product Catalog Grid (BILLIONES)
     * URL: http://127.0.0.1:8000/catalog
     */
    public function index(Request $request): View
    {
        try {
            // Fetches paginated products using your service layer filters
            $products = $this->productService->getAllProducts(
                categoryId: $request->integer('category_id') ?: null,
                search: $request->string('search')->toString() ?: null,
                perPage: $request->integer('per_page', 12) // Optimized 12 items for grid balance
            );

            // Renders Billiones' Blade file, passing the database records into it
            return view('products::index', compact('products'));
        } catch (Exception $e) {
            abort(500, 'Error loading product catalog: ' . $e->getMessage());
        }
    }

    /**
     * Display the Frontend Product Detail Page (LOVELY)
     * URL: http://127.0.0.1:8000/catalog/{id}
     */
    public function show(int $id): View
    {
        try {
            $product = $this->productService->getProductById($id);

            if (!$product) {
                abort(404, 'Product not found');
            }

            // Renders Lovely's PDP presentation page passing the single model item
            return view('products::show', compact('product'));
        } catch (Exception $e) {
            abort(404, 'Product presentation page failed to load.');
        }
    }

    /**
     * Backend Admin Inventory API: Add a Product jang
     */
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name'              => 'required|string|max:255',
                'description'       => 'nullable|string',
                'price'             => 'required|numeric|min:0',
                'category_id'       => 'required|integer|exists:categories,id',
                'image'             => 'nullable|string',
                'inventory'         => 'nullable|array',
                'inventory.stock'   => 'nullable|integer|min:0',
            ]);

            $product = $this->productService->createProduct($validated);

            return response()->json([
                'success' => true,
                'message' => 'Product created successfully',
                'data'    => $product
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Backend Admin Inventory API: Edit a Product jang
     */
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name'              => 'nullable|string|max:255',
                'description'       => 'nullable|string',
                'price'             => 'nullable|numeric|min:0',
                'category_id'       => 'nullable|integer|exists:categories,id',
                'image'             => 'nullable|string',
                'inventory'         => 'nullable|array',
                'inventory.stock'   => 'nullable|integer|min:0',
            ]);

            $product = $this->productService->updateProduct($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Product updated successfully',
                'data'    => $product
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Backend Admin Inventory API: Delete a Product jang
     */
    public function destroy(int $id): JsonResponse
    {
        try {
            $this->productService->deleteProduct($id);

            return response()->json([
                'success' => true,
                'message' => 'Product deleted successfully'
            ], 200);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }

    /**
     * Backend API Search Endpoint (Kept for asynchronous live components)kesa
     */
    public function search(Request $request): JsonResponse
    {
        try {
            $query = $request->string('q')->toString();

            if (empty($query)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Search query is required'
                ], 400);
            }

            $products = $this->productService->searchProducts(
                $query,
                $request->integer('per_page', 15)
            );

            return response()->json([
                'success' => true,
                'data' => $products->items(),
                'meta' => [
                    'current_page' => $products->currentPage(),
                    'last_page'    => $products->lastPage(),
                    'per_page'     => $products->perPage(),
                    'total'        => $products->total(),
                ]
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Backend API Category Filtering (Kept for background data loops)kesa
     */
    public function byCategory(int $categoryId): JsonResponse
    {
        try {
            $products = $this->productService->getProductsByCategory($categoryId);

            return response()->json([
                'success' => true,
                'data'    => $products
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
}