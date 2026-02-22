<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'employee_id',
        'client_id',
        'product_id',
        'quantity',
        'total_price',
        'sale_date',
        'payment_method',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'quantity' => 'integer',
        'total_price' => 'decimal:2',
    ];

    // Relaciones
    public function employee()
    {
        return $this->belongsTo(Employee::class);
    }

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function debt()
    {
        return $this->hasOne(ClientDebt::class);
    }

    public function details()
    {
        return $this->hasMany(SaleDetail::class);
    }
}