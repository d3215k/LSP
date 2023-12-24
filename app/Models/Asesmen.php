<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asesmen extends Model
{
    use HasFactory;

    protected $table = 'asesmen';

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class);
    }

    public function rincian(): HasOne
    {
        return $this->hasOne(RincianDataPemohon::class);
    }

}
