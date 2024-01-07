<?php

namespace App\Models\Asesmen;

use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KomponenUmpanBalik extends Model
{
    use HasFactory;

    protected $table = 'komponen_umpan_balik';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public $timestamps = false;
}
