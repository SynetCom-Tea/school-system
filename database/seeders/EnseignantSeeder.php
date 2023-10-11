<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Modules\Enseignement\Entities\Enseignant;


class EnseignantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Enseignant::create([
            'matricule' => 'Mat/093',
            'nom' => 'Sani Abou',
            'prenom' => 'Mahamadou',
            'sex' => 'Masculin',
            'date_naissance'=>'1991-10-19',
            'lieu_naissance'=>'MARADI',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/094',
            'nom' => 'Djafar Alambouzou',
            'prenom' => 'Madougou',
            'sex' => 'Masculin',
            'date_naissance'=>'1992-10-19',
            'lieu_naissance'=>'MARADI',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/095',
            'nom' => 'Karim Tankari',
            'prenom' => 'Alfari',
            'sex' => 'Masculin',
            'date_naissance'=>'1988-10-19',
            'lieu_naissance'=>'MARADI',
            'etablissement_id' => 1
        ]);
        Enseignant::create([
            'matricule' => 'Mat/043',
            'nom' => 'Sani Chipkaou',
            'prenom' => 'Kadidja',
            'sex' => 'Féminin',
            'date_naissance'=>'2000-10-19',
            'lieu_naissance'=>'MARADI',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/013',
            'nom' => 'Wahab Dan Takoussa',
            'prenom' => 'Rouwaida',
            'sex' => 'Féminin',
            'date_naissance'=>'2001-10-19',
            'lieu_naissance'=>'MARADI',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/099',
            'nom' => 'Garba Labizé',
            'prenom' => 'Bello',
            'sex' => 'Masculin',
            'date_naissance'=>'1989-10-19',
            'lieu_naissance'=>'NIAMEY',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/063',
            'nom' => 'Djibo Dan Malam',
            'prenom' => 'Mayaki',
            'sex' => 'Masculin',
            'date_naissance'=>'1990-10-19',
            'lieu_naissance'=>'ZINDER',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/066',
            'nom' => 'Nourou Hainikoy',
            'prenom' => 'Bouchira',
            'sex' => 'Féminin',
            'date_naissance'=>'1999-10-19',
            'lieu_naissance'=>'DOSSO',
            'etablissement_id' => 1,
        ]);
        Enseignant::create([
            'matricule' => 'Mat/055',
            'nom' => 'Nafiou Bonkaney',
            'prenom' => 'Wazir',
            'sex' => 'Masculin',
            'date_naissance'=>'1987-10-19',
            'lieu_naissance'=>'TILLABERY',
            'etablissement_id' => 1,
        ]);
    }
}
