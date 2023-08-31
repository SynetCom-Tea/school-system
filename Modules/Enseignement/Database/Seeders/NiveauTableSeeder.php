<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\Niveau;

class NiveauTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        Niveau::create([
            'libelle' => 'CI',
            'section_id' => 1
        ]);
        Niveau::create([
            'libelle' => 'CP',
            'section_id' => 1
        ]);
        Niveau::create([
            'libelle' => 'CE1',
            'section_id' => 1
        ]);
        Niveau::create([
            'libelle' => 'CE2',
            'section_id' => 1
        ]);
        Niveau::create([
            'libelle' => 'CM1',
            'section_id' => 1
        ]);
        Niveau::create([
            'libelle' => 'CM2',
            'section_id' => 1
        ]);
        Niveau::create([
            'libelle' => '6ème',
            'section_id' => 2
        ]);
        Niveau::create([
            'libelle' => '5ème',
            'section_id' => 2
        ]);
        Niveau::create([
            'libelle' => '4ème',
            'section_id' => 2
        ]);
        Niveau::create([
            'libelle' => '3ème',
            'section_id' => 2
        ]);
        Niveau::create([
            'libelle' => 'Second A',
            'section_id' => 3
        ]);
        Niveau::create([
            'libelle' => 'Second C',
            'section_id' => 3
        ]);
        Niveau::create([
            'libelle' => 'T A',
            'section_id' => 3
        ]);
        Niveau::create([
            'libelle' => 'T C',
            'section_id' => 3
        ]);
        Niveau::create([
            'libelle' => 'T D',
            'section_id' => 3
        ]);
        Niveau::create([
            'libelle' => '1ème Annee',
            'section_id' => 4
        ]);
        Niveau::create([
            'libelle' => '2ème Annee',
            'section_id' => 4
        ]);
        Niveau::create([
            'libelle' => '3ème Annee',
            'section_id' => 4
        ]);
        Niveau::create([
            'libelle' => '4ème Annee',
            'section_id' => 4
        ]);
        Niveau::create([
            'libelle' => '5ème Annee',
            'section_id' => 4
        ]);

        // $this->call("OthersTableSeeder");
    }
}
