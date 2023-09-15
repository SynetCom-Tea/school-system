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
            'nom' => 'SVT'
        ]);
        Matiere::create([
            'nom' => 'HG'
        ]);
        Matiere::create([
            'nom' => 'Mathematique'
        ]);
        Matiere::create([
            'nom' => 'Histoire'
        ]);

        // $this->call("OthersTableSeeder");
    }
}
