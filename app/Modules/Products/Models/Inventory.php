<?php //neil

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $table = 'inventory';
    protected $fillable = [
        'product_id',
        'stock',
    ];
    protected $casts = [
        'product_id' => 'integer',
        'stock' => 'integer',
    ];
    protected $attributes = [
        'stock' => 0,
    ];
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}