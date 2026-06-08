<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Builder;

class ConditionalOffer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];
    protected $casts = [
        'starts_at' => 'datetime',
        'ends_at'   => 'datetime',
    ];
}
