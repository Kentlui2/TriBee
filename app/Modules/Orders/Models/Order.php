<?php

declare(strict_types=1);

namespace App\Modules\Orders\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    // Ensure these match the columns in your migration
    protected $fillable = ['user_id', 'total', 'status'];
}