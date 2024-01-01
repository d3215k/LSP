<?php

namespace App\Models;

use App\Enums\SekolahType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Sekolah extends Model
{
    use HasFactory;

    protected $table = 'sekolah';

    protected $casts = [
        'type' => SekolahType::class,
    ];

    public function kompetensiKeahlian(): BelongsToMany
    {
        return $this->belongsToMany(KompetensiKeahlian::class);
    }
}
