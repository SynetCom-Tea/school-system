<?php

namespace Database\Seeders;

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
            'nom' => 'SVT',
            'etablissement_section_id'=>8
        ]);
        Matiere::create([
            'nom' => 'HG',
            'etablissement_section_id'=>8
        ]);
        Matiere::create([
            'nom' => 'Mathematique',
            'etablissement_section_id'=>9
        ]);
        Matiere::create([
            'nom' => 'Histoire',
            'etablissement_section_id'=>9
        ]);

        // $this->call("OthersTableSeeder");
    }
}
