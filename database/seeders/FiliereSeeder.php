<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Filiere;

class FiliereSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();
        Filiere::create([
            'name' =>'Analyste Programmeur',
            'code'=>'AP',
            'etablissement_section_id'=>3,
            'departement_id'=>null
        ]);
        Filiere::create([
            'name' =>'Informatique et Gestion',
            'code'=>'IG',
            'etablissement_section_id'=>3,
            'departement_id'=>null
        ]);
        Filiere::create([
            'name' =>'Genie Logiciel',
            'code'=>'GL',
            'etablissement_section_id'=>4,
            'departement_id'=>null
        ]);
        
    }
}
