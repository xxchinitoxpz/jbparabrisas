<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'company_name',
        'ruc_dni',
        'phone',
        'description',
    ];

    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
