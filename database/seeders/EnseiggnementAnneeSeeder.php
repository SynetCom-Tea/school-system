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
            'classe_annee_id' => 1,
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
            'niveau_matiere_id' => null,
            'enseignant_id' => 2,
            'classe_annee_id' => 8,
            'filiere_niveau_matiere_ue_id'=>2
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => null,
            'enseignant_id' => 2,
            'classe_annee_id' => 8,
            'filiere_niveau_matiere_ue_id'=>3
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => null,
            'enseignant_id' => 2,
            'classe_annee_id' => 9,
            'filiere_niveau_matiere_ue_id'=>1
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => null,
            'enseignant_id' => 2,
            'classe_annee_id' => 9,
            'filiere_niveau_matiere_ue_id'=>2
        ]);
        EnseignementAnnee::create([
            'niveau_matiere_id' => null,
            'enseignant_id' => 2,
            'classe_annee_id' => 8,
            'filiere_niveau_matiere_ue_id'=>1
        ]);
    }
}
