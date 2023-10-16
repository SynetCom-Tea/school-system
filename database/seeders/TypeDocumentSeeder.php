<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\TypeDocument;

class TypeDocumentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TypeDocument::create(['libelle' => 'Certificat de Nationalité']);
        TypeDocument::create(['libelle' => 'Acte de naissance']);
        TypeDocument::create(['libelle' => 'Rélévé de notes']);
        TypeDocument::create(['libelle' => 'Dernier diplome']);
        TypeDocument::create(['libelle' => 'Frais de Formation']);
    }
}
