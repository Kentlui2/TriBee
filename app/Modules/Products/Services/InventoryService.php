<?php 

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{
    // Data Retrieval: Fetches stock levels by product.
    // Managed by: Member 4 Francis (Admin Inventory API)
    public function getByProductId(int $productId): ?Inventory
    {
        return Inventory::where('product_id', $productId)->first();
    }
     // Data Retrieval: Fetches raw inventory row.
     // Managed by: Member 4 (Admin Inventory API)
    public function getById(int $id): ?Inventory
    {
        return Inventory::find($id);
    }
    // Data Reporting: Retrieves all stock items for audit.
    // Managed by: Member 4 (Admin Inventory API)
    public function getAllInventory(): Collection
    {
        return Inventory::with('product')->get();
    }
    // Admin Action: Initializes inventory for a new product.
    // Managed by: Member 4 (Admin Inventory API)
    public function createInventory(array $data): Inventory
    {
        $existing = $this->getByProductId((int) $data['product_id']);

        if ($existing) {
            throw new Exception("Inventory record already exists for product ID {$data['product_id']}");
        }

        return Inventory::create([
            'product_id' => $data['product_id'],
            'stock'      => $data['stock'] ?? 0, // Corrected from quantity -> stock
        ]);
    }
    //Admin Action: Updates existing stock levels.
    // Managed by: Member 4 (Admin Inventory API)
    public function updateInventory(int $id, array $data): Inventory
    {
        $inventory = $this->getById($id);

        if (!$inventory) {
            throw new Exception("Inventory log entry not found");
        }

        $inventory->update([
            'stock' => $data['stock'] ?? $inventory->stock,
        ]);

        return $inventory->fresh();
    }
     // Logistics: Adds incoming stock to inventory.
     // Managed by: Member 5 Norhalija (Database & Inventory Tracking)

    public function addStock(int $productId, int $quantity): Inventory
    {
        $inventory = $this->getByProductId($productId);

        if (!$inventory) {
            throw new Exception("Inventory record not found for product ID {$productId}");
        }

        $inventory->increment('stock', $quantity);

        return $inventory->fresh();
    }
    //Logistics: Subtracts outgoing stock (manual adjustments).
    //  Managed by: Member 5 (Database & Inventory Tracking) 
    public function removeStock(int $productId, int $quantity): Inventory
    {
        $inventory = $this->getByProductId($productId);

        if (!$inventory) {
            throw new Exception("Inventory record not found for product ID {$productId}");
        }

        if ($inventory->stock < $quantity) {
            throw new Exception("Insufficient stock parameters. Available: {$inventory->stock}, Requested: {$quantity}");
        }

        $inventory->decrement('stock', $quantity);

        return $inventory->fresh();
    }
    // Core Integration: Atomic purchase logic with DB locking.
    // Managed by: Member 6 Norkesa (Lead / Concurrency Control)
    public function securePurchase(int $productId, int $quantity): bool
    {
        return DB::transaction(function () use ($productId, $quantity) {
            $inventory = Inventory::where('product_id', $productId)->lockForUpdate()->first();

            if ($inventory && $inventory->stock >= $quantity) {
                $inventory->decrement('stock', $quantity);
                return true;
            }

            return false; // Out of stock or record missing
        });
    }
     //Integration API: Check if items can be added to cart.
     //Managed by: Member 5 (Database & Inventory Tracking) 
    public function checkAvailability(int $productId, int $requestedQuantity): bool
    {
        $inventory = $this->getByProductId($productId);

        if (!$inventory) {
            return false;
        }

        return $inventory->stock >= $requestedQuantity;
    }
     // Data Reporting: Filter for out-of-stock products.
     // Managed by: Member 5 (Database & Inventory Tracking)
    public function getOutOfStockItems(): Collection
    {
        return Inventory::with('product')->where('stock', '<=', 0)->get();
    }
}