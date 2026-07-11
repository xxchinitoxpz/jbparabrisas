<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CruceroJaenJob extends Model
{
    protected $fillable = [
        'job_date',
        'description',
        'status',
        'photos',
    ];

    protected $casts = [
        'job_date' => 'date',
        'photos' => 'array',
    ];
}
