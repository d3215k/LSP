<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Enums\UserType;
use App\Models\Scopes\AktifScope;
use Filament\Panel;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'type',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'aktif' => 'boolean',
        'type' => UserType::class,
    ];

    protected static function booted(): void
    {
        static::addGlobalScope(new AktifScope);
    }

    public function getIsAdminAttribute(): bool
    {
        return $this->type === UserType::ADMIN;
    }

    public function getIsAsesorAttribute(): bool
    {
        return $this->type === UserType::ASESOR;
    }

    public function getIsAsesiAttribute(): bool
    {
        return $this->type === UserType::ASESI;
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return true;
    }

    public function canImpersonate()
    {
        return $this->type === UserType::ADMIN;
    }

    public function asesi(): BelongsTo
    {
        return $this->belongsTo(Asesi::class);
    }

    public function getRedirectRoute()
    {
        return match((int)$this->type) {
            1 => route('filament.app.pages.dashboard'),
            2 => route('filament.app.pages.dashboard'),
            3 => route('filament.app.pages.beranda'),
        };
    }

    public function resetPassword()
    {
        $this->password = bcrypt('smkn1cbd*');
        $this->save();
    }
}
