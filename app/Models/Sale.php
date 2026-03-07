<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sale extends Model
{
     use SoftDeletes;
    protected $fillable = [
        'employee_id',
        'client_id',
        'product_id',
        'quantity',
        'total_price',
        'sale_date',
        'payment_method',
         'status',
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
    // Metodos de  estado  de venta 
    // Métodos de Estado
    public function isCancelled(): bool
    {
        return $this->status === 'cancelled';
    }

    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    public function canBeCancelled(): bool
    {
        // Solo se puede cancelar si está completada
        return $this->status === 'completed';
    }

     /**
     * Cancelar la venta y devolver el stock
     */
    public function cancel(): bool
    {
        if (!$this->canBeCancelled()) {
            return false;
        }

        // Devolver stock al producto
        $this->product->increment('stock', $this->quantity);

        // Marcar como cancelada
        $this->update(['status' => 'cancelled']);

        return true;
    }
     /**
     * Revertir cancelación
     */
    public function revert(): bool
    {
        if ($this->status !== 'cancelled') {
            return false;
        }

        // Verificar si hay stock suficiente para revertir
        if (!$this->product->hasStock($this->quantity)) {
            return false;
        }

        // Quitar stock del producto
        $this->product->decrement('stock', $this->quantity);

        // Marcar como completada
        $this->update(['status' => 'completed']);

        return true;
    }

}