<?php

namespace Database\Seeders;

use App\Models\Section;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SectionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Section::create([
            'libelle' => 'Primaire'
        ]);
        Section::create([
            'libelle' => 'Secondaire'
        ]);
        Section::create([
            'libelle' => 'Supérieur'
        ]);
        Section::create([
            'libelle' => 'Universitaire'
        ]);

        Role::create([
            'name' => 'Super-administrateur',
            'guard_name'=>'web',
        ]);
        Role::create([
            'name' => 'Administrateur',
            'guard_name'=>'web',
        ]);
        Role::create([
            'name' => 'Enseignant',
            'guard_name'=>'web',
        ]);
        Role::create([
            'name' => 'Apprenant',
            'guard_name'=>'web',
        ]);
        Role::create([
            'name' => 'Proviseur',
            'guard_name'=>'web',
        ]);
        Role::create([
            'name' => 'APT',
            'guard_name'=>'web',
        ]);
        Role::create([
            'name' => 'Surveillant',
            'guard_name'=>'web',
        ]);
    }
}
