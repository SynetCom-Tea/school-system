<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class TuteursTableSeeder extends Seeder
{

    /**
     * Auto generated seed file
     *
     * @return void
     */
    public function run()
    {
        

        \DB::table('tuteurs')->delete();
        
        \DB::table('tuteurs')->insert(array (
            0 => 
            array (
                'id' => 1,
                'nom' => 'Moctar',
                'prenom' => 'Talle',
                'telephone' => '90231241',
                'adresse' => NULL,
                'email' => 'moctar@tal.le',
                'sexe' => NULL,
                'created_at' => '2023-10-26 14:00:39',
                'updated_at' => '2023-10-26 14:00:39',
                'deleted_at' => NULL,
            ),
            1 => 
            array (
                'id' => 2,
                'nom' => 'Saydi',
                'prenom' => 'Mahamane Ibrah',
                'telephone' => '96457885',
                'adresse' => NULL,
                'email' => 'jk@gh.ds',
                'sexe' => NULL,
                'created_at' => '2023-10-26 14:06:11',
                'updated_at' => '2023-10-26 14:06:11',
                'deleted_at' => NULL,
            ),
            2 => 
            array (
                'id' => 3,
                'nom' => 'Ali',
                'prenom' => 'Garba',
                'telephone' => '91856934',
                'adresse' => NULL,
                'email' => 'alihaf@fbjzuz.com',
                'sexe' => NULL,
                'created_at' => '2023-10-28 07:17:31',
                'updated_at' => '2023-10-28 07:17:31',
                'deleted_at' => NULL,
            ),
            3 => 
            array (
                'id' => 4,
                'nom' => 'Samaila',
                'prenom' => 'Daouda',
                'telephone' => '70258694',
                'adresse' => NULL,
                'email' => 'vsghzah@hgfhezueiek.com',
                'sexe' => NULL,
                'created_at' => '2023-10-28 07:21:17',
                'updated_at' => '2023-10-28 07:21:17',
                'deleted_at' => NULL,
            ),
        ));
        
        
    }
}