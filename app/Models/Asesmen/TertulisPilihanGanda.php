<?php

namespace App\Models\Asesmen;

use App\Enums\AsesmenTertulisStatus;
use App\Models\Asesmen;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class TertulisPilihanGanda extends Model
{
    use HasFactory;

    protected $table = 'asesmen_tertulis_pilihan_ganda';

    protected $casts = [
        'status' => AsesmenTertulisStatus::class,
    ];

    public function asesmen(): BelongsTo
    {
        return $this->belongsTo(Asesmen::class);
    }

    public function jawaban(): HasMany
    {
        return $this->hasMany(JawabanTertulisPilihanGanda::class, 'asesmen_tertulis_pilihan_ganda_id');
    }

    public function kompeten()
    {
        return $this->jawaban()->where('kompeten', true);
    }

    public function belumKompeten()
    {
        return $this->jawaban()->where('kompeten', false);
    }

    public function resetWaktu()
    {
        $this->created_at = now();
        $this->updated_at = now();
        $this->save();
    }

    public function forceFinish()
    {
        $this->status = AsesmenTertulisStatus::SELESAI;
        $this->save();
    }
}
