<?php

namespace App\Models\Asesmen;

use App\Models\Asesmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TertulisEsai extends Model
{
    use HasFactory;

    protected $table = 'asesmen_tertulis_esai';

    public function asesmen(): BelongsTo
    {
        return $this->belongsTo(Asesmen::class);
    }

}
