<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FlashDeal extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'start_date',
        'end_date',
        'products',
        'status',
    ];
}
