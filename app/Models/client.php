<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client extends Model
{
    //
    protected $fillable = [
        'first_name',
        'last_name',
        'phone',
        'email',
        'street_1',
        'street_2',
        'neighborhood',
        'zip_code'
    ];

     public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    public function debts()
    {
        return $this->hasMany(client_debt::class);
    }

}
