<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    //
    protected $fillable = [
        'company_name',
        'contact_name',
        'phone',
        'email'
    ];
    // estas son las relaciones que tendran 
    public function products() // un proveedor puede tener muchos productos
    {
        return $this->hasMany(Product::class);
    }

    public function debts()
    {
        // Un proveedor tiene muchas deudas
        return $this->hasMany(SupplierDebt::class);
    }
}
