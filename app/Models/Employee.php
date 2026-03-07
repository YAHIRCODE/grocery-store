<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
class Employee extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'user_id',
        'role_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'full_address',
        'payroll_id',
        'hourly_rate',
        'card_number',
    ];

    protected $casts = [
        'hourly_rate' => 'decimal:2',
    ];

    // Relaciones
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function sales()
    {
        return $this->hasMany(Sale::class);
    }

    // Método auxiliar
    public function getFullNameAttribute()
    {
        return "{$this->first_name} {$this->last_name}";
    }
}