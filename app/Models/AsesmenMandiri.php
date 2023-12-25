<?php

namespace App\Models;

use App\Enums\RekomendasiAsesmenMandiri;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AsesmenMandiri extends Model
{
    use HasFactory;

    protected $table = 'asesmen_mandiri';

    protected $casts = [
        'rekomendasi' => RekomendasiAsesmenMandiri::class,
    ];

    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanAsesmenMandiri::class);
    }
}
