<?php

namespace App\Models\Asesmen;

use App\Models\Scopes\AktifScope;
use App\Models\Scopes\SortScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PertanyaanTertulisPilihanGanda extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_tertulis_pilihan_ganda';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
        static::addGlobalScope(new SortScope);
    }

    public function pilihanJawaban(): HasMany
    {
        return $this->hasMany(
            PilihanJawaban::class,
            'pertanyaan_tertulis_pilihan_ganda_id'
        );
    }
}
