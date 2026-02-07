<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    //
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'barcode',
        'price',
        'barcode',
        'current_stock',
        'min_stock',
        'purchase_price',
        'retail_price'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function saleDetails()
    {
        return $this->hasMany(SaleDetail::class);
    }

}
