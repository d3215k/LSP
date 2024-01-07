<?php

namespace App\Models\Asesmen;

use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PertanyaanTertulisEsai extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_tertulis_esai';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }
}
