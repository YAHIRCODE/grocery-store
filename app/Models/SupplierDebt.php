<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class SupplierDebt extends Model
{
   use SoftDeletes;
    protected $fillable = [
        'supplier_id',
        'start_date',
        'due_date',
        'amount',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'amount' => 'decimal:2',
    ];

    // Relaciones
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    // Métodos auxiliares
    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date < Carbon::today();
    }
}