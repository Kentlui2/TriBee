<?php 

namespace App\Modules\Products\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Entity: Category
// Managed by: Member 5 (Database & Schema Integrity)

class Category extends Model
{
    use HasFactory;

    // FIXED: Added 'slug' to the fillable array so seeders can save it!
    protected $fillable = ['name', 'slug', 'description', 'image_url'];
    
    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}