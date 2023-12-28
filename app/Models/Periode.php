<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Periode extends Model
{
    use HasFactory;

    protected $table = 'periode';

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function periode(): HasOne
    {
        return $this->hasOne(Periode::class);
    }
}
