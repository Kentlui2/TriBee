<?php

declare(strict_types=1);

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Product;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Exception;

class ProductService
{
        // Search and Filter API (price, brand, rating) Memeber 3 Sayson  
    public function getAllProducts(
        ?int $categoryId = null,
        ?string $search = null,
        ?float $minPrice = null,
        ?float $maxPrice = null,
        ?string $brand = null,
        ?int $rating = null,
        int $perPage = 15
    ): LengthAwarePaginator {
        $query = Product::with(['category', 'inventory']);

        // Filter by category if supplied
        if ($categoryId) {
            $query->where('category_id', $categoryId);
        }

        // Search filter (Name & Description)
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Filter Price Range (Minimum / Maximum)
        if ($minPrice !== null) {
            $query->where('price', '>=', $minPrice);
        }
        if ($maxPrice !== null) {
            $query->where('price', '<=', $maxPrice);
        }

        if ($brand) {
            $query->when(Schema::hasColumn('products', 'brand'), function ($q) use ($brand) {
                return $q->where('brand', $brand);
            });
        }

        if ($rating !== null) {
            $query->when(Schema::hasColumn('products', 'rating'), function ($q) use ($rating) {
                return $q->where('rating', '>=', $rating);
            });
        }

        return $query->latest()->paginate($perPage);
    }
    // Catalog/Product Page: Fetches specific product data.
    // Managed by: Member 1 Billiones (Frontend Catalog)
    public function getProductById(int $id): Product
    {
        return Product::with(['category', 'inventory'])->findOrFail($id);
    }
        //Admin panel API (Create, Update, Delete) Member 4 Francis
    public function createProduct(array $data): Product
    {
        return DB::transaction(function () use ($data) {
            $product = Product::create([
                'name'        => $data['name'],
                'description' => $data['description'] ?? null,
                'price'       => $data['price'],
                'category_id' => $data['category_id'],
                'image'       => $data['image'] ?? null,
                'brand'       => $data['brand'] ?? null,
                'rating'      => $data['rating'] ?? 0,
            ]);

            $product->inventory()->create([
                'stock' => $data['inventory']['stock'] ?? 0,
            ]);

            return $product->fresh(['category', 'inventory']);
        });
    }
        // Admin Action: Updates existing product and its inventory linkage.
        //  Managed by: Member 4 (Admin Inventory API)
    public function updateProduct(int $id, array $data): Product
    {
        $product = $this->getProductById($id);

        return DB::transaction(function () use ($product, $data) {
            $product->update([
                'name'        => $data['name'] ?? $product->name,
                'description' => $data['description'] ?? $product->description,
                'price'       => $data['price'] ?? $product->price,
                'category_id' => $data['category_id'] ?? $product->category_id,
                'image'       => $data['image'] ?? $product->image,
                'brand'       => $data['brand'] ?? $product->brand,
                'rating'      => $data['rating'] ?? $product->rating,
            ]);

            if (isset($data['inventory']['stock'])) {
                $product->inventory()->update([
                    'stock' => $data['inventory']['stock'],
                ]);
            }

            return $product->fresh(['category', 'inventory']);
        });
    }
    // Admin Action: Removes product from the catalog.
    // Managed by: Member 4 Francis(Admin Inventory API)
    public function deleteProduct(int $id): bool
    {
        $product = $this->getProductById($id);
        return (bool) $product->delete();
    }
    // Search/Filter: Wrapper for product keyword searching.
    //Managed by: Member 3 Sayson (Search and Filter Logic)
    public function searchProducts(string $query, int $perPage = 15): LengthAwarePaginator
    {
        return $this->getAllProducts(search: $query, perPage: $perPage);
    }
    // Catalog: Fetches products within a specific category.
    //Managed by: Member 1 Billiones (Frontend Catalog)
    public function getProductsByCategory(int $categoryId, int $perPage = 12): \Illuminate\Pagination\LengthAwarePaginator
    {
        return Product::with(['category', 'inventory'])
            ->where('category_id', $categoryId)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * API Contract for G3 & G4: Get product with inventory info
     * 
     * @param int $productId
     * @return Product Product with category and inventory relationships loaded
     */
    public function getProduct(int $productId): Product
    {
        return $this->getProductById($productId);
    }
   
}
