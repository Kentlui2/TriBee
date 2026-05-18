<?php //neil

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'category_id',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'category_id' => 'integer',
    ];

    protected $with = ['inventory'];
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }
    public function inventory(): HasOne
    {
        return $this->hasOne(Inventory::class);
    }
}