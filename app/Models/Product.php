<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
        'code',
        'name',
        'purchase_price',
        'sale_price',
        'description',
    ];

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }

    public function inventories()
    {
        return $this->hasMany(Inventory::class);
    }
}
