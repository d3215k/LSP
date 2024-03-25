<?php

namespace App\Models;

use App\Enums\JenisSkema;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $casts = [
        'jenis' => JenisSkema::class,
        'unit' => 'array',
        'tanggal_terbit' => 'date',
    ];

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

}
