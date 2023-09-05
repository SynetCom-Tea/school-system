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
        $admin = User::create([
            'email' => 'super-admin@gmail.com',
            'password' => Hash::make('password')
        ]);
        $super_admin = Role::firstOrcreate(['name' => 'Super-administrateur']);
        $super_admin->givePermissionTo(Permission::where('name', '<>', 'etudiant')->where('name', '<>', 'manage_school')->get());
        $admin->assignRole($super_admin);

        $chef = User::create([
            'nom' => 'Ali',
            'prenom' => 'Mohamed',
            'sex' => 'M',
            'date_naissance' => NULL,
            'lieu_naissance' => NULL,
            'telephone' => 90909089,
            'email' => 'admin@gmail.com',
            'password' => Hash::make('password')
        ]);
        $ad_school = Role::create(['name' => 'Administrateur']);
        $ad_school->givePermissionTo('manage_school');
        $chef->assignRole($ad_school);
    }
}
