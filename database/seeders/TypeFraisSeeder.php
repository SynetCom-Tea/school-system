<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Scolarite\Entities\TypeFrais;

class TypeFraisSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //

        TypeFrais::create(['id' => 1, 'libelle' => 'Frais d\'inscription', 'etablissement_id' => 1]);
        TypeFrais::create(['id' => 2, 'libelle' => 'Frais de scolarité', 'etablissement_id' => 1]);
        TypeFrais::create(['id' => 3, 'libelle' => 'Frais de transport commun', 'etablissement_id' => 1]);
        TypeFrais::create(['id' => 4, 'libelle' => 'Frais de cantine', 'etablissement_id' => 1]);
    }
}
