<?php

namespace App\Models\Asesmen;

use App\Models\Skema\Unit;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PertanyaanObservasiPendukung extends Model
{
    use HasFactory;

    protected $table = 'pertanyaan_observasi_pendukung';

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

}
