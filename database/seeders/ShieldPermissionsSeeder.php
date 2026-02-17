<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ShieldPermissionsSeeder extends Seeder
{
    public function run(): void
    {
        // Permessi per UserResource
        $userPermissions = [
            'view_any_users',
            'view_users',
            'create_users',
            'update_users',
            'delete_users',
            'restore_users',
            'force_delete_users',
            'replicate_users',
            'reorder_users',
        ];

        // Permessi generali del pannello
        $panelPermissions = [
            'view_admin',
            'access_admin',
        ];

        // Crea tutti i permessi
        $allPermissions = array_merge($userPermissions, $panelPermissions);
        
        foreach ($allPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Assegna tutti i permessi al super_admin
        $superAdmin = Role::where('name', 'super_admin')->first();
        if ($superAdmin) {
            $superAdmin->givePermissionTo(Permission::all());
        }

        $this->command->info('✅ Shield permissions generated successfully!');
        $this->command->info('📊 Total permissions: ' . Permission::count());
    }
}
