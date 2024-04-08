<?php

namespace App\Models\Skema;

use App\Models\Asesmen\PertanyaanObservasiPendukung;
use App\Models\Asesmen\PertanyaanTertulisEsai;
use App\Models\Asesmen\PertanyaanTertulisPilihanGanda;
use App\Models\Scopes\AktifScope;
use App\Models\Scopes\SortScope;
use App\Models\Skema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Unit extends Model
{
    use HasFactory;

    protected $table = 'unit';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
        static::addGlobalScope(new SortScope);
    }

    public function elemen(): HasMany
    {
        return $this->hasMany(Elemen::class);
    }

    public function kuk(): HasManyThrough
    {
        return $this->hasManyThrough(KriteriaUnjukKerja::class, Elemen::class);
    }

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function pertanyaanObservasiPendukung(): HasMany
    {
        return $this->hasMany(PertanyaanObservasiPendukung::class);
    }

    public function pertanyaanTertulisEsai(): HasMany
    {
        return $this->hasMany(PertanyaanTertulisEsai::class);
    }

    public function pertanyaanTertulisPilihanGanda(): HasMany
    {
        return $this->hasMany(PertanyaanTertulisPilihanGanda::class);
    }

}
