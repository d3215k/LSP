<?php

namespace App\Models;

use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KompetensiKeahlian extends Model
{
    use HasFactory;

    protected $table = 'kompetensi_keahlian';

    public $timestamps = false;

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public function sekolah(): BelongsToMany
    {
        return $this->belongsToMany(Sekolah::class);
    }
}
