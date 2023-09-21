<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public $models = [
        'role' => 'un rôle',
        'user' => 'un utilisateur',
        'permission' => 'une permission',
        'evaluation' => 'une évaluation',
        'matiere' => 'une matiere',
        'niveau' => 'un niveau',
        'Filiere' => 'une Filière',
        'ue' => 'un ue',
        'apprenant' => 'un apprenant',
        'etablissement' => 'un etablissement',
        'annee' => 'une annee',
        'salle' => 'une salle',
        'horaire' => 'un horaire',

    ];
    public function run(): void
    {
        Permission::create(['name' => 'enseignant', 'description' => 'Permission Enseignant']);
        Permission::create(['name' => 'apprenant', 'description' => 'Permission Apprenant']);
        Permission::create(['name' => 'tuteur', 'description' => 'Permission Tuteur']);
        Permission::create(['name' => 'responsable-enseignant', 'description' => 'Permission Responsable-Enseignant']);
        Permission::create(['name' => 'manage_school', 'description' => 'Permission Administrateur']);
        Permission::create(['name' => 'manage_welcome', 'description' => 'Paramètrage du welcome']);
        Permission::create(['name' => 'manage_system', 'description' => 'Paramètre systeme']);
        foreach ($this->models as $k => $v) {
            Permission::create(['name' => $k . '.create', 'description' => 'Peut ajouter ' . $v]);
            Permission::create(['name' => $k . '.read', 'description' => 'Peut voir ' . $v]);
            Permission::create(['name' => $k . '.update', 'description' => 'Peut modifier ' . $v]);
            Permission::create(['name' => $k . '.delete', 'description' => 'Peut supprimer ' . $v]);
        }
    }
}
