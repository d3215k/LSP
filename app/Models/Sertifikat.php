<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Sertifikat extends Model
{
    use HasFactory;

    protected $table = 'sertifikat';

    protected $casts = [
        'unit' => 'object',
        'tanggal_terbit' => 'date',
    ];

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

}
