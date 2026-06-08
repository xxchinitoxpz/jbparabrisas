<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    protected $fillable = [
        'voucher_type',
        'voucher_number',
        'referral_guide_number',
        'total',
        'supplier_id',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchaseDetails()
    {
        return $this->hasMany(PurchaseDetail::class);
    }
}
