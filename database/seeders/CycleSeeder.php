<?php

namespace Database\Seeders;

use App\Models\Cycle;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CycleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Cycle::create([
            'name' => 'Cycle Moyen',
        ]);
        Cycle::create([
            'name' => '1er cycle',
        ]);
        Cycle::create([
            'name' => '2e cycle',
        ]);
        Cycle::create([
            'name' => '3e cycle',
        ]);
        Cycle::create([
            'name' => '4e cycle',
        ]);
    }
}
