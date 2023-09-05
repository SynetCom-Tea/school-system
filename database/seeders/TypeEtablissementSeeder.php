<?php

namespace Database\Seeders;

use App\Models\TypeEtablissement;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TypeEtablissementSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeEtablissement::create(['name' => 'University']);
        TypeEtablissement::create(['name' => 'Ecole']);
        TypeEtablissement::create(['name' => 'Institut']);
    }
}
