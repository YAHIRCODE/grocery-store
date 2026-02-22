<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class ClientDebt extends Model
{
    protected $fillable = [
        'client_id',
        'sale_id',
        'start_date',
        'due_date',
        'balance_due',
        'status',
    ];

    protected $casts = [
        'start_date' => 'date',
        'due_date' => 'date',
        'balance_due' => 'decimal:2',
    ];

    // Relaciones
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }

    // Métodos auxiliares
    public function isOverdue()
    {
        return $this->status === 'pending' && $this->due_date < Carbon::today();
    }

    public function markAsOverdue()
    {
        if ($this->isOverdue()) {
            $this->update(['status' => 'overdue']);
        }
    }
}