<?php

namespace App\Models\Skema;

use App\Models\Skema;
use App\Models\Asesmen\BuktiPersyaratan;
use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Persyaratan extends Model
{
    use HasFactory;

    protected $table = 'persyaratan';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function bukti(): HasOne
    {
        return $this->hasOne(BuktiPersyaratan::class);
    }
}
