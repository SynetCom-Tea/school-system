<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Enseignant;

class EnseignantTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Enseignant::create([
            'matricule' => 'Mat/En/09',
            'nom' => 'Rahim Larwan',
            'prenom' => 'Narwa',
        ]);
        Enseignant::create([
            'matricule' => 'Mat/En/04',
            'nom' => 'Hamissou Maïga',
            'prenom' => 'Ibrahim',
        ]);

        // $this->call("OthersTableSeeder");
    }
}
