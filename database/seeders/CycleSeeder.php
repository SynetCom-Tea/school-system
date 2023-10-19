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
