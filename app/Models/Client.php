<?php

namespace App\Models;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
     use SoftDeletes;
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'street_1',
        'street_2',
        'neighborhood',
        'credit_limit', // Agregado según tu descripción del proyecto
        'current_debt', // Para llevar control del total adeudado
    ];

    protected $casts = [
        'credit_limit' => 'decimal:2',
        'current_debt' => 'decimal:2',
    ];

    // Relaciones
    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function debts()
    {
        return $this->hasMany(ClientDebt::class);
    }

    // Métodos auxiliares
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }

    public function getFullAddressAttribute()
    {
        return "{$this->street_1}, {$this->street_2}, {$this->neighborhood}";
    }

    public function hasAvailableCredit($amount)
    {
        return ($this->current_debt + $amount) <= $this->credit_limit;
    }

    public function getPendingDebts()
    {
        return $this->debts()->whereIn('status', ['pending', 'overdue'])->sum('balance_due');
    }
}