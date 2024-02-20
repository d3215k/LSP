<?php

namespace App\Models\Skema;

use App\Models\Scopes\AktifScope;
use App\Models\Scopes\SortScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class KriteriaUnjukKerja extends Model
{
    use HasFactory;

    protected $table = 'kriteria_unjuk_kerja';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
        static::addGlobalScope(new SortScope);

    }

    public function elemen(): BelongsTo
    {
        return $this->belongsTo(Elemen::class);
    }

}
