<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'company_name',
        'contact_name',
        'phone',
        'email',
    ];

    // Relaciones
    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function debts()
    {
        return $this->hasMany(SupplierDebt::class);
    }

    // Método auxiliar
    public function getTotalDebt()
    {
        return $this->debts()->whereIn('status', ['pending', 'overdue'])->sum('amount');
    }
}