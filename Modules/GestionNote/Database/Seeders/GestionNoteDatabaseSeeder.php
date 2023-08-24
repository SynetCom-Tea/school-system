<?php

namespace Modules\GestionNote\Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;

class GestionNoteDatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Model::unguard();

        // $this->call("PeriodeTableSeeder");
        $this->call([
            PeriodeTableSeeder::class,
        ]);
    }
}
