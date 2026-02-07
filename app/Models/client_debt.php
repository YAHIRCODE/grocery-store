<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class client_debt extends Model
{
    //
    protected $fillable = [
        'client_id',
        'sale_id',
        'start_date',
        'due_date',
        'balance_due',
        'status'
    ];

    public function client()
    {
        return $this->belongsTo(client::class);
    }
    public function sale()
    {
        return $this->belongsTo(Sale::class);
    }
}
