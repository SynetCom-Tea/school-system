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
        
        $super_admin = User::create([
            'email' => 'super-admin@gmail.com',
            'password' => Hash::make('password'),
            'nom' => 'super',
            'prenom' => 'Administrateur',
        ]);
        $roles = Role::firstOrcreate(['name' => 'Super-administrateur']);
        $super_admin->givePermissionTo(Permission::where('name','manage_system')->get());
        $super_admin->assignRole($roles);
    }
}
