<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $fillable = [
        'product_id',
        'quantity',
        'stored_date',
        'supplier_id',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
