<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    //
    protected $fillable = [
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'full_address',
        'payroll_id',
        'hourly_rate',
        'card_number'
    ];
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
