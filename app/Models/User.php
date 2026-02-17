<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Gate;
use Jeffgreco13\FilamentBreezy\Traits\TwoFactorAuthenticatable;  // <--- Per Breezy
use OwenIt\Auditing\Auditable as AuditableTrait;  // <--- Fondamentale
use OwenIt\Auditing\Contracts\Auditable;  // <--- AGGIUNGI QUESTO
use Spatie\Permission\Traits\HasRoles;  // <--- Per Filament Shield

class User extends Authenticatable implements Auditable
{
    use AuditableTrait;

    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    // <--- USA IL TRAIT
    use HasRoles;  // Aggiungi questi Trait
    use TwoFactorAuthenticatable;

    public function boot(): void
    {
        Gate::define('viewPulse', function (User $user) {
            // Opzione A: Autorizza per email specifica
            // return $user->email === 'tua-email@esempio.com';

            // Opzione B: Autorizza tramite Filament Shield (se hai creato il ruolo super_admin)
            return $user->hasRole('super_admin');
        });
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
