<?php

namespace App\Models;

use App\Enums\JenisSkema;
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
}
