<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Mockery\Matcher\Type;
use Modules\Scolarite\Entities\TypeFrais;

class TypeFraisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        TypeFrais::create(['id' => 1, 'libelle' => 'Frais d\'inscription']);
        TypeFrais::create(['id' => 2, 'libelle' => 'Frais de scolarité']);
        TypeFrais::create(['id' => 3, 'libelle' => 'Frais de laboratoire']);
        TypeFrais::create(['id' => 4, 'libelle' => 'Frais de Bibliothèque et COGES']);
        TypeFrais::create(['id' => 5, 'libelle' => 'Frais de logement']);
        TypeFrais::create(['id' => 6, 'libelle' => 'Frais de transport commun']);
        TypeFrais::create(['id' => 7, 'libelle' => 'Frais de cantine']);
        TypeFrais::create(['id' => 8, 'libelle' => 'Frais de Formation']);
    }
}
