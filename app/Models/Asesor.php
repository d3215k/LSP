<?php

namespace App\Models;

use App\Models\Scopes\AktifScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Asesor extends Model
{
    use HasFactory;

    protected $table = 'asesor';

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public function user(): HasOne
    {
        return $this->hasOne(User::class);
    }

    public function skema(): BelongsToMany
    {
        return $this->belongsToMany(Skema::class);
    }
}
