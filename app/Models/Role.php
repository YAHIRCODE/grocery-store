<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    //
     protected $fillable = [
         'rol_name',
         'password',
         'employee_id'
     ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }

}
