<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Enseignant;
use Modules\Enseignement\Entities\EnseignantMatiere;

class EnseignantMatiereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        EnseignantMatiere::create([
            'enseignant_id' =>1,
            'matiere_id' => 1,

        ]);
        EnseignantMatiere::create([
            'enseignant_id' =>1,
            'matiere_id' => 3,

        ]);
        EnseignantMatiere::create([
            'enseignant_id' =>2,
            'matiere_id' => 2,

        ]);
        EnseignantMatiere::create([
            'enseignant_id' =>2,
            'matiere_id' => 4,

        ]);
        EnseignantMatiere::create([
            'enseignant_id' =>2,
            'matiere_id' => 5,

        ]);
        EnseignantMatiere::create([
            'enseignant_id' =>1,
            'matiere_id' => 6,

        ]);
        EnseignantMatiere::create([
            'enseignant_id' =>1,
            'matiere_id' => 7,

        ]);

        // $this->call("OthersTableSeeder");
    }
}
