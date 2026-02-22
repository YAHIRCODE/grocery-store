<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class employee extends Model
{
    //
    protected $fillable = [
        'user_id',
        'rol',
        'first_name',
        'last_name',
        'email',
        'phone',
        'full_address',
        'payroll_id',
        'hourly_rate',
        'card_number'
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }
}
