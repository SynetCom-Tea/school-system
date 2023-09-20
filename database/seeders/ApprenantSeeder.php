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
                'matricule' => 'Mat/093',
                'nom' => 'Sani Abou',
                'prenom' => 'Mahamadou',
                'etablissement_id' => 1,
            ),
            1 =>
            array(

                'matricule' => 'Mat/094',
                'nom' => 'Djafar Alambouzou',
                'prenom' => 'Madougou',
                'etablissement_id' => 1,
            ),
            2 =>
            array(
                'matricule' => 'Mat/095',
                'nom' => 'Karim Tankari',
                'prenom' => 'Alfari',
                'etablissement_id' => 1,
            ),
            3 =>
            array(

                'matricule' => 'Mat/043',
                'nom' => 'Sani Chipkaou',
                'prenom' => 'Kadidja',
                'etablissement_id' => 1,
            ),
            4 =>
            array(

                'matricule' => 'Mat/013',
                'nom' => 'Wahab Dan Takoussa',
                'prenom' => 'Rouwaida',
                'etablissement_id' => 1,
            ),
            5 =>
            array(

                'matricule' => 'Mat/099',
                'nom' => 'Garba Labizé',
                'prenom' => 'Bello',
                'etablissement_id' => 1,
            ),
            6 =>
            array(
                'matricule' => 'Mat/063',
                'nom' => 'Djibo Dan Malam',
                'prenom' => 'Mayaki',
                'etablissement_id' => 1,
            ),
            7 =>
            array(

                'matricule' => 'Mat/066',
                'nom' => 'Nourou Hainikoy',
                'prenom' => 'Bouchira',
                'etablissement_id' => 1,
            ),
            8 =>
            array(

                'matricule' => 'Mat/055',
                'nom' => 'Nafiou Bonkaney',
                'prenom' => 'Wazir',
                'etablissement_id' => 1,
            )
        ));
    }
}
