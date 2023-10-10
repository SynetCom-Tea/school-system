<?php

namespace Database\Seeders;

use App\Models\Apprenant;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ApprenantSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('apprenants')->insert(array(
            0 =>
            array(
                'matricule' => 'Mat/01PrimCE12023',
                'nom' => 'Sani Abou',
                'prenom' => 'Mahamadou',
                'etablissement_id' => 1,
                'sexe' => 'Masculin',
                'date_naissance' => '12/01/2015',
                'lieu_naissance' => 'Madaoua',
                'telephone' => '70123456',
            ),
            1 =>
            array(

                'matricule' => 'Mat/02PrimCM22023',
                'nom' => 'Djafar',
                'prenom' => 'Madina',
                'etablissement_id' => 1,
                'sexe' => 'Féminin',
                'date_naissance' => '27/08/2011',
                'lieu_naissance' => 'Niamey',
                'telephone' => '77123456',
            ),
            2 =>
            array(
                'matricule' => 'Mat/01Coll5eme2023',
                'nom' => 'Karim Tankari',
                'prenom' => 'Alfari',
                'etablissement_id' => 1,
                'sexe' => 'Masculin',
                'date_naissance' => '13/06/2009',
                'lieu_naissance' => 'Konni',
                'telephone' => '97123456',
            ),
            3 =>
            array(

                'matricule' => 'Mat/02Coll3eme2023',
                'nom' => 'Sani Chipkaou',
                'prenom' => 'Kadidja',
                'etablissement_id' => 1,
                'sexe' => 'Féminin',
                'date_naissance' => '23/04/2006',
                'lieu_naissance' => 'Téra',
                'telephone' => '87123456',
            ),
            4 =>
            array(

                'matricule' => 'Mat/02Lycee2nde2023',
                'nom' => 'Wahab Dan Takoussa',
                'prenom' => 'Rouwaida',
                'etablissement_id' => 1,
                'sexe' => 'Féminin',
                'date_naissance' => '04/12/2006',
                'lieu_naissance' => 'Niamey',
                'telephone' => '88123456',
            ),
            5 =>
            array(

                'matricule' => 'Mat/02LyceeTle2023',
                'nom' => 'Garba Labizé',
                'prenom' => 'Bello',
                'etablissement_id' => 1,
                'sexe' => 'Masculin',
                'date_naissance' => '18/07/2004',
                'lieu_naissance' => 'Niamey',
                'telephone' => '94123488',
            ),
            6 =>
            array(
                'matricule' => 'Mat/063',
                'nom' => 'Djibo Dan Malam',
                'prenom' => 'Mayaki',
                'etablissement_id' => 1,
                'sexe' => 'Masculin',
                'date_naissance' => '18/07/2004',
                'lieu_naissance' => 'Niamey',
                'telephone' => '94213488',
            ),
            7 =>
            array(

                'matricule' => 'Mat/066',
                'nom' => 'Nourou Hainikoy',
                'prenom' => 'Bouchira',
                'etablissement_id' => 1,
                'sexe' => 'Féminin',
                'date_naissance' => '18/07/1995',
                'lieu_naissance' => 'Niamey',
                'telephone' => '94124388',
            ),
            8 =>
            array(

                'matricule' => 'Mat/055',
                'nom' => 'Nafiou Bonkaney',
                'prenom' => 'Wazir',
                'etablissement_id' => 1,
                'sexe' => 'Masculin',
                'date_naissance' => '18/07/2000',
                'lieu_naissance' => 'Niamey',
                'telephone' => '88123498',
            )
        ));
    }
}
