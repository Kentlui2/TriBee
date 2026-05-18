<?php //france

namespace App\Modules\Products\Services;

use App\Modules\Products\Models\Inventory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

class InventoryService
{

    public function getByProductId(int $productId): ?Inventory
    {
        return Inventory::where('product_id', $productId)->first();
    }

    public function getById(int $id): ?Inventory
    {
        return Inventory::find($id);
    }

    public function getAllInventory(): Collection
    {
        return Inventory::with('product')->get();
    }

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

    public function addStock(int $productId, int $quantity): Inventory
    {
        $inventory = $this->getByProductId($productId);

        if (!$inventory) {
            throw new Exception("Inventory record not found for product ID {$productId}");
        }

        $inventory->increment('stock', $quantity);

        return $inventory->fresh();
    }

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
    //checkStock(int $productId, int $qty): bool
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
    //decrementStock(int $productId, int $qty): void
    public function checkAvailability(int $productId, int $requestedQuantity): bool
    {
        $inventory = $this->getByProductId($productId);

        if (!$inventory) {
            return false;
        }

        return $inventory->stock >= $requestedQuantity;
    }

    public function getOutOfStockItems(): Collection
    {
        return Inventory::with('product')->where('stock', '<=', 0)->get();
    }
}