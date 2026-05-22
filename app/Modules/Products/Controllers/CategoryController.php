<?php

declare(strict_types=1);

namespace App\Modules\Products\Controllers;

use App\Http\Controllers\Controller;
use App\Modules\Products\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Exception;

class CategoryController extends Controller
{
// TASK ASSIGNMENT: MEMBER 1 (Billiones - Frontend Storefront Integration)
    public function index(): JsonResponse // List all categories
    {
        try {
            $categories = Category::withCount('products')->get();

            return response()->json([
                'success' => true,
                'data' => $categories
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
// TASK ASSIGNMENT: MEMBER 4 (Francis - Admin Inventory API Management)
    public function store(Request $request): JsonResponse // Create category
    {
        try {
            // Replaced legacy external FormRequests with inline validation
            $validated = $request->validate([
                'name'        => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category = Category::create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category created successfully',
                'data'    => $category
            ], 201);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
// TASK ASSIGNMENT: MEMBER 1 (Billiones - Frontend Storefront Integration)
    public function show(int $id): JsonResponse
    {
        try {
            $category = Category::with('products')
                ->withCount('products')
                ->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'data'    => $category
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 500);
        }
    }
    //TASK ASSIGNMENT: MEMBER 4 (Francis - Admin Inventory API Management)
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            $category = Category::find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            $validated = $request->validate([
                'name'        => 'nullable|string|max:255',
                'description' => 'nullable|string',
            ]);

            $category->update($validated);

            return response()->json([
                'success' => true,
                'message' => 'Category updated successfully',
                'data'    => $category
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
    // TASK ASSIGNMENT: MEMBER 4 (Francis - Admin Inventory API Management)
    public function destroy(int $id): JsonResponse
    {
        try {
            $category = Category::withCount('products')->find($id);

            if (!$category) {
                return response()->json([
                    'success' => false,
                    'message' => 'Category not found'
                ], 404);
            }

            if ($category->products_count > 0) {
                return response()->json([
                    'success' => false,
                    'message' => "Cannot delete category with {$category->products_count} products"
                ], 400);
            }

            $category->delete();

            return response()->json([
                'success' => true,
                'message' => 'Category deleted successfully'
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage()
            ], 400);
        }
    }
}