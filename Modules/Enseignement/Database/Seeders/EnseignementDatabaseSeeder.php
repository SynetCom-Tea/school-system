<?php

namespace Modules\Enseignement\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class EnseignementDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        $this->call([
            EnseignantTableSeeder::class,
            MatiereTableSeeder::class,
            NiveauTableSeeder::class,
            NiveauMatiereTableSeeder::class,
            EnseignantAnneeTableSeeder::class,
        ]);
    }
}
