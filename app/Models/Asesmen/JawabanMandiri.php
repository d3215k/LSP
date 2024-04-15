<?php

namespace App\Models\Asesmen;

use App\Models\Skema\Elemen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class JawabanMandiri extends Model
{
    use HasFactory;

    protected $table = 'jawaban_mandiri';

    public function asesmenMandiri(): BelongsTo
    {
        return $this->belongsTo(Mandiri::class);
    }

    public function bukti(): BelongsTo
    {
        return $this->belongsTo(BuktiMandiri::class);
    }

    public function elemen(): BelongsTo
    {
        return $this->belongsTo(Elemen::class);
    }
}
