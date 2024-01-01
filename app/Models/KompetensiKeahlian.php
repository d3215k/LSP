<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class KompetensiKeahlian extends Model
{
    use HasFactory;

    protected $table = 'kompetensi_keahlian';

    public $timestamps = false;

    public function sekolah(): BelongsToMany
    {
        return $this->belongsToMany(Sekolah::class);
    }
}
