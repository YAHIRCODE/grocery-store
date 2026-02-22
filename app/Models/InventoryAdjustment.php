<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InventoryAdjustment extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'adjustment_type', // 'addition' o 'subtraction'
        'reason',
        'adjustment_date',
    ];

    protected $casts = [
        'quantity' => 'integer',
        'adjustment_date' => 'date',
    ];

    // Relaciones
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}