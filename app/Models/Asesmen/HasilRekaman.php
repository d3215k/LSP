<?php

namespace App\Models\Asesmen;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HasilRekaman extends Model
{
    use HasFactory;

    protected $table = 'hasil_rekaman';

    protected $casts = [
        'observasi_demonstrasi' => 'boolean',
        'portofolio' => 'boolean',
        'pernyataan_pihak_ketiga_pertanyaan_wawancara' => 'boolean',
        'pertanyaan_lisan' => 'boolean',
        'pertanyaan_tertulis' => 'boolean',
        'proyek_kerja' => 'boolean',
        'lainnya' => 'boolean',
    ];

}
