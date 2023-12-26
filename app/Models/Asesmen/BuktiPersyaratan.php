<?php

namespace App\Models\Asesmen;

use App\Enums\BuktiPersyaratanStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BuktiPersyaratan extends Model
{
    use HasFactory;

    protected $table = 'bukti_persyaratan';

    protected $casts = [
        'status' => BuktiPersyaratanStatus::class,
    ];
}
