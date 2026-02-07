<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class inventoryAdjustment extends Model
{
    //
    protected $fillable = [
        'product_id',
        'quantity',
        'adjustment_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }


}
