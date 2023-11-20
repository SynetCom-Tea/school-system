<?php

namespace App\Imports;

use Modules\GestionNote\Entities\Note;
use Maatwebsite\Excel\Concerns\ToModel;

class NoteImport implements ToModel
{
    public function model(array $row)
    {
        // Créez une instance de votre modèle avec les données de la ligne Excel
        return new Note([
            'column1' => $row[0],
            'column2' => $row[1],
            // ... autres colonnes ...
        ]);
    }
}