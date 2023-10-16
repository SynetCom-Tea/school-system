<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Enseignement\Entities\EnseignementAnnee;

class EnseiggnementAnneeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        EnseignementAnnee::create([
            'niveau_matiere_id' => 7,
            'enseignant_id' => 1,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 2,
            'enseignant_id' => 2,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 3,
            'enseignant_id' => 3,
            'classe_annee_id' => 4
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 4,
            'enseignant_id' => 4,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 9,
            'enseignant_id' => 5,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 6,
            'enseignant_id' => 6,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 1,
            'enseignant_id' => 7,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 8,
            'enseignant_id' => 8,
            'classe_annee_id' => 4,
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => 5,
            'enseignant_id' => 9,
            'classe_annee_id' => 4,
        ]);
    }
}
