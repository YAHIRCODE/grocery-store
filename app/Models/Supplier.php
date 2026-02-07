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
}
