<?php

namespace Database\Seeders;

use App\Models\ClasseAnnee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClasseAnneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClasseAnnee::create([
            'date_debut' => '2022-10-01',
            'date_fin' => '2023-06-30',
            'classe_id' => 1,
            'annee_scolaire_id' => 1,
        ]);

        ClasseAnnee::create([
            'date_debut' => '2022-10-01',
            'date_fin' => '2023-06-30',
            'classe_id' => 2,
            'annee_scolaire_id' => 1,
        ]);

        ClasseAnnee::create([
            'date_debut' => '2022-10-01',
            'date_fin' => '2023-06-30',
            'classe_id' => 3,
            'annee_scolaire_id' => 1,
        ]);
    }
}
