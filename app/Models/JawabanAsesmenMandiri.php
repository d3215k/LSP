<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanAsesmenMandiri extends Model
{
    use HasFactory;

    protected $table = 'jawaban_asesmen_mandiri';

    public function asesmenMandiri(): BelongsTo
    {
        return $this->belongsTo(AsesmenMandiri::class);
    }

    public function bukti(): BelongsTo
    {
        return $this->belongsTo(BuktiAsesmenMandiri::class);
    }

    public function elemen(): BelongsTo
    {
        return $this->belongsTo(Elemen::class);
    }
}
