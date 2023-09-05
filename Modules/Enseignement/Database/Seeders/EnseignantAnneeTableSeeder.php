<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\EnseignantAnnee;

class EnseignantAnneeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        EnseignantAnnee::create([
            'enseignant_id' => 1,
            'classe_annee_id' => 1,
            'niveau_matiere_id' => 1,
        ]);

        EnseignantAnnee::create([
            'enseignant_id' => 2,
            'classe_annee_id' => 2,
            'niveau_matiere_id' => 1,
        ]);

        EnseignantAnnee::create([
            'enseignant_id' => 1,
            'classe_annee_id' => 3,
            'niveau_matiere_id' => 2,
        ]);

        // $this->call("OthersTableSeeder");
    }
}
