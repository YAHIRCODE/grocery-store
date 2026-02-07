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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
