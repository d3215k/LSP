<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asesi extends Model
{
    use HasFactory;

    protected $table = 'asesi';

    public function sekolah(): BelongsTo
    {
        return $this->belongsTo(Sekolah::class);
    }

    public function kompetensiKeahlian(): BelongsTo
    {
        return $this->belongsTo(KompetensiKeahlian::class);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function asesmen(): HasMany
    {
        return $this->hasMany(Asesmen::class);
    }

}
