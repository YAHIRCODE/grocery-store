<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SupplierDebt extends Model
{
    //
    protected $fillable = [
        'supplier_id',
        'due_date',
        'amount',
        'status'
    ];
    protected $casts = [
        'due_date' => 'date',
        'amount' => 'decimal:2'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
