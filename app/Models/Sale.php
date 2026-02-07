<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    //
    protected $fillable = [
        'employee_id',
        'client_id',
        'sale_date',
        'payment_method',
        'total_amount'
    ];

    public function employee()
    {
        return $this->belongsTo(employee::class);
    }

    public function client()
    {
        return $this->belongsTo(client::class);
    }
}
