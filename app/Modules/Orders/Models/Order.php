<?php

declare(strict_types=1);

namespace App\Modules\Orders\Models;

use App\Modules\Auth\Models\User;  
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    protected $fillable = [
        'user_id', 'subtotal', 'discount', 'tax', 'shipping_fee',
        'total', 'status', 'shipping_address', 'contact_number', 'notes'
    ];

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}