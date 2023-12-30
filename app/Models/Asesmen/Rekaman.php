<?php

namespace App\Models\Asesmen;

use App\Enums\RekomendasiRekamanAsesmen;
use App\Models\Asesmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Rekaman extends Model
{
    use HasFactory;

    protected $table = 'asesmen_rekaman';

    protected $casts = [
        'rekomendasi' => RekomendasiRekamanAsesmen::class,
    ];

    public function asesmen(): BelongsTo
    {
        return $this->belongsTo(Asesmen::class);
    }
}
