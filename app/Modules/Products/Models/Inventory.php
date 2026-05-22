<?php

declare(strict_types=1);

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

//Entity: Inventory
//Managed by: Member 5 Norhalija(Database & Schema Integrity)

class Inventory extends Model
{
    protected $fillable = ['product_id', 'stock'];

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}