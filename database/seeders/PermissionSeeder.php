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
        'matiere' => 'une matière',
        'frais' => 'un frais',
        'classe' => 'une classe',
        'enseignant' => 'un enseignant',
        'salle' => 'une salle',
        'absent' => 'une absent',
        'emplois' => 'un emplois',
        'evaluation' => 'une évaluation',
        'note' => 'une note'
    ];
    public $modelsSup = [
        'filiere' => 'une filière',
        'ue' => 'un ue',
        'section' => 'une section'
    ];
    public function run(): void
    {
        Permission::create(['name' => 'manage_welcome', 'description' => 'Paramètrage du welcome']);
        Permission::create(['name' => 'manage_system', 'description' => 'Paramètre systeme']);
        Permission::create(['name' => 'manage_school', 'description' => 'Administrateur etablissement']);
        Permission::create(['name' => 'manage_section', 'description' => 'Gestion des section']);
        Permission::create(['name' => 'manage_config', 'description' => 'Post configurations']);
        Permission::create(['name' => 'versement', 'description' => 'Effectuer un versement']);
        Permission::create(['name' => 'liste_inscrit', 'description' => 'Liste des inscrits']);
        Permission::create(['name' => 'inscription', 'description' => 'Faire une nouvelle inscription']);
        Permission::create(['name' => 'calendrier', 'description' => 'Calendrier']);
        Permission::create(['name' => 'bulletin', 'description' => 'Génération des bulletins']);
        Permission::create(['name' => 'manage_etablissement', 'description' => 'Paramètre etablissement']);
        Permission::create(['name' => 'espace_tuteur', 'description' => 'Espace tuteur']);
        Permission::create(['name' => 'affectation_niveau_matiere.read', 'description' => 'Liste des affectation des matières au niveau']);
        Permission::create(['name' => 'affectation_niveau_matiere.create', 'description' => 'Faire une affectation des matières au niveau']);
        Permission::create(['name' => 'affectation_niveau_matiere.update', 'description' => 'Modifier une affectation des matières au niveau']);
        Permission::create(['name' => 'affectation_niveau_matiere.delete', 'description' => 'Supprimer une affectation des matières au niveau']);
        Permission::create(['name' => 'affectation_enseignant', 'description' => 'Affectation des enseignants']);
        Permission::create(['name' => 'espace_enseignant', 'description' => 'Espace enseignant']);
        Permission::create(['name' => 'espace_comptable', 'description' => 'Espace comptable']);
        Permission::create(['name' => 'espace_etudiant', 'description' => 'Espace Étudiant']);
        Permission::create(['name' => 'responsable-enseignant', 'description' => 'Permission Responsable-Enseignant']);

        Permission::create(['name' => 'create_annees', 'description' => "Créer des années scolaires"]);
        Permission::create(['name' => 'edit_annee', 'description' => "Modifier une année scolaire"]);
        Permission::create(['name' => 'delete_annee', 'description' => "Supprimer une année scolaire"]);
        
        foreach ($this->models as $k => $v) {
            Permission::create(['name' => $k . '.create', 'description' => 'Peut ajouter ' . $v]);
            Permission::create(['name' => $k . '.read', 'description' => 'Peut voir ' . $v]);
            Permission::create(['name' => $k . '.update', 'description' => 'Peut modifier ' . $v]);
            Permission::create(['name' => $k . '.delete', 'description' => 'Peut supprimer ' . $v]);
        }
        foreach ($this->modelsSup as $k => $v) {
            Permission::create(['name' => $k . '.create', 'description' => 'Peut ajouter ' . $v, 'section_id' => 3]);
            Permission::create(['name' => $k . '.read', 'description' => 'Peut voir ' . $v, 'section_id' => 3]);
            Permission::create(['name' => $k . '.update', 'description' => 'Peut modifier ' . $v, 'section_id' => 3]);
            Permission::create(['name' => $k . '.delete', 'description' => 'Peut supprimer ' . $v, 'section_id' => 3]);
        }
    }
}
