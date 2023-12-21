<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'persyaratan';

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function bukti(): HasOne
    {
        return $this->hasOne(BuktiPersyaratan::class);
    }
}
