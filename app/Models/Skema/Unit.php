<?php

namespace App\Models\Skema;

use App\Models\Asesmen\PertanyaanObservasiPendukung;
use App\Models\Skema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';

    public function elemen(): HasMany
    {
        return $this->hasMany(Elemen::class);
    }

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function pertanyaanObservasiPendukung(): HasMany
    {
        return $this->hasMany(PertanyaanObservasiPendukung::class);
    }

}
