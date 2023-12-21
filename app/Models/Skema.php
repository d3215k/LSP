<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Skema extends Model
{
    use HasFactory;

    protected $table = 'skema';

    public function units(): HasMany
    {
        return $this->hasMany(Unit::class);
    }

    public function persyaratan(): HasMany
    {
        return $this->hasMany(Persyaratan::class);
    }
}
