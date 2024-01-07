<?php

namespace App\Models;

use App\Enums\JenisTempatUjiKompetensi;
use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class TempatUjiKompetensi extends Model
{
    use HasFactory;

    protected $table = 'tempat_uji_kompetensi';

    protected $casts = [
        'jenis' => JenisTempatUjiKompetensi::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public function skema(): BelongsToMany
    {
        return $this->belongsToMany(Skema::class);
    }
}
