<?php

namespace App\Models;

use App\Enums\AsesmenStatus;
use App\Enums\TujuanAsesmen;
use App\Models\Asesmen\Banding;
use App\Models\Asesmen\BuktiMandiri;
use App\Models\Asesmen\BuktiPersyaratan;
use App\Models\Asesmen\Mandiri;
use App\Models\Asesmen\ObservasiAktivitas;
use App\Models\Asesmen\ObservasiPendukung;
use App\Models\Asesmen\Persetujuan;
use App\Models\Asesmen\Rekaman;
use App\Models\Asesmen\RincianDataPemohon;
use App\Models\Asesmen\TertulisEsai;
use App\Models\Asesmen\UmpanBalik;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asesmen extends Model
{
    use HasFactory;

    // protected $hidden = [
    //     'ttd_asesi',
    //     'ttd_asesor',
    // ];

    protected $casts = [
        'status' => AsesmenStatus::class,
        'tujuan' => TujuanAsesmen::class,
    ];

    protected $table = 'asesmen';

    public function skema(): BelongsTo
    {
        return $this->belongsTo(Skema::class);
    }

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class);
    }

    public function asesor(): BelongsTo
    {
        return $this->belongsTo(Asesor::class);
    }

    public function periode(): BelongsTo
    {
        return $this->belongsTo(Periode::class);
    }

    public function rincianDataPemohon(): HasOne
    {
        return $this->hasOne(RincianDataPemohon::class)->orderBy('nama');
    }

    public function buktiPersyaratan(): HasMany
    {
        return $this->hasMany(BuktiPersyaratan::class);
    }

    public function buktiMandiri(): HasMany
    {
        return $this->hasMany(BuktiMandiri::class);
    }

    public function mandiri(): HasOne
    {
        return $this->hasOne(Mandiri::class);
    }

    public function tertulisEsai(): HasOne
    {
        return $this->hasOne(TertulisEsai::class);
    }

    public function rekaman(): HasOne
    {
        return $this->hasOne(Rekaman::class);
    }

    public function persetujuan(): HasOne
    {
        return $this->hasOne(Persetujuan::class);
    }

    public function observasiPendukung(): HasOne
    {
        return $this->hasOne(ObservasiPendukung::class);
    }

    public function observasiAktivitas(): HasOne
    {
        return $this->hasOne(ObservasiAktivitas::class);
    }

    public function umpanBalik(): HasOne
    {
        return $this->hasOne(UmpanBalik::class);
    }

    public function banding(): HasOne
    {
        return $this->hasOne(Banding::class);
    }

}
