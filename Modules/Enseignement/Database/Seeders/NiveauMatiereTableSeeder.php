<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\NiveauMatiere;

class NiveauMatiereTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        NiveauMatiere::create([
            'code' => 'SVT/6eme',
            'coefficient' => 3,
            'volume_horaire' => 40,
            'niveau_id' => 7,
            'matiere_id' => 1,
        ]);

        NiveauMatiere::create([
            'code' => 'SVT/3eme',
            'coefficient' => 4,
            'volume_horaire' => 70,
            'niveau_id' => 10,
            'matiere_id' => 1,
        ]);

        NiveauMatiere::create([
            'code' => 'HG/6eme',
            'coefficient' => 2,
            'volume_horaire' => 20,
            'niveau_id' => 7,
            'matiere_id' => 2,
        ]);

        // $this->call("OthersTableSeeder");
    }
}
