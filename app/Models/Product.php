<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
     use SoftDeletes; // ← AGREGAR
    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'description',
        'barcode',
        'stock', // Cambiado de current_stock para consistencia
        'min_stock',
        'purchase_price',
        'price', // retail_price (para consistencia con controllers)
    ];

    protected $casts = [
        'stock' => 'integer',
        'min_stock' => 'integer',
        'purchase_price' => 'decimal:2',
        'price' => 'decimal:2',
    ];

    // Relaciones
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

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function inventoryAdjustments()
    {
        return $this->hasMany(InventoryAdjustment::class);
    }

    // Métodos auxiliares
    public function isLowStock()
    {
        return $this->stock <= $this->min_stock;
    }

    public function hasStock($quantity = 1)
    {
        return $this->stock >= $quantity;
    }
}