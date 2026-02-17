<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShieldSeeder extends Seeder
{
    public function run(): void
    {
        // Genera tutti i permessi per le risorse Filament usando il comando
        // \Artisan::call('shield:generate', ['--all' => true, '--no-interaction' => true]);

        // Crea ruolo super_admin se non esiste
        $superAdmin = Role::firstOrCreate(['name' => 'super_admin']);

        // Assegna tutti i permessi esistenti al super_admin
        if (Permission::count() > 0) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        // Crea utente super_admin se non esiste (solo in ambiente locale)
        if (app()->environment('local')) {
            $user = User::firstOrCreate([
                'email' => 'super_admin@cstar.local',
            ], [
                'name' => 'Super Admin',
                'password' => bcrypt('password'),
            ]);

            $user->assignRole('super_admin');
        }
    }
}
