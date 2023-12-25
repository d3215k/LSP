<?php

namespace App\Models;

use App\Enums\AsesmenStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asesmen extends Model
{
    use HasFactory;

    protected $casts = [
        'status' => AsesmenStatus::class,
    ];

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

    public function bukti(): HasMany
    {
        return $this->hasMany(BuktiPersyaratan::class);
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

}
