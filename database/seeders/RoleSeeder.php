<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $superadmin = User::create([
            'nom' => 'Tondi',
            'prenom' => 'Bouli',
            'email' => 'super-admin@gmail.com',
            'password' => Hash::make('password')
        ]);
        $admin = User::create([
            'nom' => 'Admin',
            'prenom' => 'Administrateur',
            'user_id' => 1,
            'etablissement_id' => 1,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);

        // Super admin
        $super_admin = Role::firstOrcreate(['name' => 'Super-administrateur']);
        $super_admin->givePermissionTo(Permission::where('name', '<>', 'etudiant')->get());
        $superadmin->assignRole($super_admin);

        // Admin
        $administrateur = Role::firstOrcreate(['name' => 'Administrateur']);
        $administrateur->givePermissionTo(Permission::where('name', '<>', 'etudiant')->get());
        $admin->assignRole($administrateur);
    }
}
