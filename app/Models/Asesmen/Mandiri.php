<?php

namespace App\Models\Asesmen;

use App\Enums\RekomendasiAsesmenMandiri;
use App\Models\Asesmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Mandiri extends Model
{
    use HasFactory;

    protected $table = 'asesmen_mandiri';

    protected $casts = [
        'rekomendasi' => RekomendasiAsesmenMandiri::class,
    ];

    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanMandiri::class);
    }

    public function asesmen(): BelongsTo
    {
        return $this->belongsTo(Asesmen::class);
    }
}
