<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();
        Cycle::create(['name' => 'Premier cycle']);
        Cycle::create(['name' => 'Deuxième cycle']);
        Cycle::create(['name' => 'Troisième cycle']);
    }
}
