<?php

namespace App\Models;

use App\Enums\JenisTempatUjiKompetensi;
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

    public function skema(): BelongsToMany
    {
        return $this->belongsToMany(Skema::class);
    }
}
