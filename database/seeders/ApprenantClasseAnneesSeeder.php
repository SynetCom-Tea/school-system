<?php

namespace Database\Seeders;

use App\Models\ApprenantClasseAnnee;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprenantClasseAnneesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        //
        ApprenantClasseAnnee::create([
            'id' => 1,
            'classe_annee_id' => 1,
            'apprenant_id' => 1,
        ]);
        ApprenantClasseAnnee::create([
            'id' => 2,
            'classe_annee_id' => 2,
            'apprenant_id' => 2,
        ]);
        ApprenantClasseAnnee::create([
            'id' => 3,
            'classe_annee_id' => 3,
            'apprenant_id' => 3,
        ]);
        ApprenantClasseAnnee::create([
            'id' => 4,
            'classe_annee_id' => 4,
            'apprenant_id' => 4,
        ]);
        ApprenantClasseAnnee::create([
            'id' => 5,
            'classe_annee_id' => 5,
            'apprenant_id' => 5,
        ]);
        ApprenantClasseAnnee::create([
            'id' => 6,
            'classe_annee_id' => 6,
            'apprenant_id' => 6,
        ]);
        ApprenantClasseAnnee::create([
            'id' => 7,
            'classe_annee_id' => 7,
            'apprenant_id' => 7,
        ]);
    }
}
