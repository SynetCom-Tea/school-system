<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Modules\Enseignement\Entities\CycleFiliere;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CycleFiliereSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        CycleFiliere::create([
            'cycle_id'=>1,
            'filiere_id'=>1,
            'code'=>'1A/AP'
        ]);
        CycleFiliere::create([
            'cycle_id'=>2,
            'filiere_id'=>2,
            'code'=>'2A/IG'
        ]);
        CycleFiliere::create([
            'cycle_id'=>3,
            'filiere_id'=>3,
            'code'=>'3A/GL'
        ]);
    }
}
