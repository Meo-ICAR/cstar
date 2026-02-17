<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DeploySeeder extends Seeder
{
    public function run(): void
    {
        // 1. Assicurati che Spatie Permission svuoti la cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Crea il Ruolo Super Admin (Se non esiste)
        // Nota: 'web' è il guard di default, cambialo se usi altro
        $role = Role::firstOrCreate(
            ['name' => 'super_admin', 'guard_name' => 'web']
        );

        // 3. Crea l'Utente Admin (Prende i dati dalle variabili d'ambiente o usa default sicuri)
        $email = env('SUPER_ADMIN_EMAIL', 'admin@hassisto.eu');  // Fallback se manca env

        $user = User::updateOrCreate(
            ['email' => $email],
            [
                'name' => 'Super Admin',
                'password' => Hash::make(env('SUPER_ADMIN_PASSWORD', 'password-temporanea')),
                'email_verified_at' => now(),
            ]
        );

        // 4. Assegna il ruolo
        // syncRoles è meglio di assignRole perché rimuove eventuali altri ruoli non voluti
        $user->syncRoles($role);

        $this->command->info("✅ DeploySeeder completato: Utente {$email} è ora Super Admin.");
    }
}
