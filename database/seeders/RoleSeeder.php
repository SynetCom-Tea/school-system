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
        // $admin = User::create([
        //     'nom' => 'Sani Abou',
        //     'prenom' => 'Mahamadou',
        //     'sex' => 'M',
        //     'sex' => 'M',
        //     'telephone' => 90909089,
        //     'email' => 'admin@gmail.com',
        //     'password' => Hash::make('password')
        // ]);
        // $super_admin = Role::firstOrcreate(['name' => 'super-dministrateur']);
        // $super_admin->givePermissionTo(Permission::where('name', '<>', 'etudiant')->get());
        // $admin->assignRole($super_admin);
    }
}
