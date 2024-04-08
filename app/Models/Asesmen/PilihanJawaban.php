<?php

namespace App\Models\Asesmen;

use App\Models\Scopes\SortScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PilihanJawaban extends Model
{
    use HasFactory;

    protected $table = 'pilihan_jawaban';

    protected $casts = [
        'kompeten' => 'bool',
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new SortScope);
    }

    public function pertanyaan(): BelongsTo
    {
        return $this->belongsTo(PertanyaanTertulisPilihanGanda::class, 'pertanyaan_tertulis_pilihan_ganda_id');
    }

}
