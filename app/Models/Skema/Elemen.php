<?php

namespace App\Models\Skema;

use App\Models\Scopes\AktifScope;
use App\Models\Scopes\SortScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Elemen extends Model
{
    use HasFactory;

    protected $table = 'elemen';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
        static::addGlobalScope(new SortScope);
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function KriteriaUnjukKerja(): HasMany
    {
        return $this->hasMany(KriteriaUnjukKerja::class);
    }

}
