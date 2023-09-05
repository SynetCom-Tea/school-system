<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Matiere;

class MatiereTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Matiere::create([
            'libelle' => 'SVT'
        ]);
        Matiere::create([
            'libelle' => 'HG'
        ]);
        Matiere::create([
            'libelle' => 'Mathematique'
        ]);
        Matiere::create([
            'libelle' => 'Histoire'
        ]);

        // $this->call("OthersTableSeeder");
    }
}
