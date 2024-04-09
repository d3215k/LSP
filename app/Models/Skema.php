<?php

namespace App\Models;

use App\Enums\JenisSkema;
use App\Models\Asesmen\PertanyaanTertulisEsai;
use App\Models\Asesmen\PertanyaanTertulisPilihanGanda;
use App\Models\Scopes\AktifScope;
use App\Models\Skema\Elemen;
use App\Models\Skema\Persyaratan;
use App\Models\Skema\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';

    protected $casts = [
        'tertulis_esai' => 'bool',
        'tertulis_pilihan_ganda' => 'bool',
        'jenis' => JenisSkema::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public function unit(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function elemen(): HasManyThrough
    {
        return $this->hasManyThrough(Elemen::class, Unit::class);
    }

    public function persyaratan(): HasMany
    {
        return $this->hasMany(Persyaratan::class);
    }

    public function tempatUjiKompetensi(): BelongsToMany
    {
        return $this->belongsToMany(TempatUjiKompetensi::class);
    }

    public function periode(): HasMany
    {
        return $this->hasMany(Periode::class);
    }

    public function asesor(): BelongsToMany
    {
        return $this->belongsToMany(Asesor::class);
    }

    public function sertifikat(): HasManyThrough
    {
        return $this->hasManyThrough(Sertifikat::class, Asesmen::class);
    }

    public function pertanyaanTertulisEsai(): HasManyThrough
    {
        return $this->hasManyThrough(PertanyaanTertulisEsai::class, Unit::class);
    }

    public function pertanyaanTertulisPilihanGanda(): HasManyThrough
    {
        return $this->hasManyThrough(PertanyaanTertulisPilihanGanda::class, Unit::class);
    }
}
