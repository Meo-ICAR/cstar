<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;  // <--- Per Breezy
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Permission\Traits\HasRoles;  // <--- Per Filament Shield

// 1. IMPORTA QUESTE CLASSI
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;


class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // <--- USA IL TRAIT
    use HasRoles;
    use LogsActivity;

    // Aggiungi questi Trait
    use TwoFactorAuthenticatable;

    /**
     * 3. AGGIUNGI QUESTO METODO
     * Questo decide chi può vedere l'admin panel in produzione.
     */
    public function canAccessPanel(Panel $panel): bool
    {
        // Se sei in locale, fai entrare tutti (comodo per test)
        if (app()->environment('local')) {
            return true;
        }

        // In Staging/Produzione:
        // Entra SOLO se ha il ruolo super_admin OPPURE se l'email è quella specifica
        return $this->hasRole('super_admin');
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logFillable()
            ->logOnlyDirty()
            ->dontSubmitEmptyLogs();
    }

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
