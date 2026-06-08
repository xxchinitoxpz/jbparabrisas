<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $fillable = [
        'company_name',
        'ruc_dni',
        'phone',
        'description',
    ];
}
