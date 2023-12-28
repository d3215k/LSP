<?php

namespace App\Models;

use App\Enums\JenisSkema;
use App\Models\Skema\Persyaratan;
use App\Models\Skema\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';

    protected $casts = [
        'jenis' => JenisSkema::class,
    ];

    public function unit(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function persyaratan(): HasMany
    {
        return $this->hasMany(Persyaratan::class);
    }

    public function tempatUjiKompetensi(): BelongsToMany
    {
        return $this->belongsToMany(TempatUjiKompetensi::class);
    }
}
