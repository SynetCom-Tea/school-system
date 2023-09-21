<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ApprenantTuteur;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RoleSeeder extends Seeder
{
        /**
         * Run the database seeds.
         */
        public function run(): void
        {

                $super_admin = User::create([
                        'nom' => 'Tondi',
                        'prenom' => 'Bouli',
                        'email' => 'super-admin@gmail.com',
                        'password' => Hash::make('password'),
                        'nom' => 'super',
                        'prenom' => 'Administrateur',
                ]);

                $roles = Role::firstOrcreate(['name' => 'Super-administrateur']);
                $super_admin->givePermissionTo(Permission::where('name', 'manage_system')->get());
                $super_admin->assignRole($roles);

                // Admin
                $admin = User::create([
                        'email' => 'admin@gmail.com',
                        'password' => Hash::make('password'),
                        'nom' => 'Admin',
                        'etablissement_id' => 1,
                        'prenom' => 'Etablissement',
                ]);

                $role_admin = Role::firstOrcreate(['name' => 'Administrateur']);
                $admin->givePermissionTo(Permission::where('name', 'manage_school')->get());
                $admin->assignRole($role_admin);
                /****************************************  2 éléves au collège et 2 au lycée ******************************************************/

                //*Apprenant1 */

                $eleve1 = User::create([
                        'email' => 'eleve1@gmail.com',
                        'password' => Hash::make('password'),
                        'apprenant_id' => 3,


                ]);

                $eleve1Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve1->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve1->assignRole($eleve1Role);

                //*Apprenant2 */

                $eleve2 = User::create([
                        'email' => 'eleve2@gmail.com',
                        'password' => Hash::make('password'),
                        'apprenant_id' => 4,

                ]);

                $eleve2Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve2->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve2->assignRole($eleve2Role);
                //*Apprenant1 */

                $eleve3 = User::create([
                        'email' => 'eleve1@gmail.com',
                        'password' => Hash::make('password'),
                        'apprenant_id' => 5,


                ]);

                $eleve3Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve3->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve3->assignRole($eleve3Role);

                //*Apprenant4 */

                $eleve4 = User::create([
                        'email' => 'eleve2@gmail.com',
                        'password' => Hash::make('password'),
                        'apprenant_id' => 6,

                ]);

                $eleve4Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve4->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve4->assignRole($eleve4Role);

                /****************************************  Fin éléves ******************************************************/



                /****************************************  6 Tuteurs ******************************************************/
                //*Tuteur1 Primaire */
                $tuteur1 = User::create([
                        'email' => 'tuteurp1@univers-school.com',
                        'password' => Hash::make('password'),
                        'tuteur_id' => 1,
                ]);
                $tuteur1Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur1->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur1->assignRole($tuteur1Role);

                //**Tuteur2 Primaire*/
                $tuteur2 = User::create([
                        'email' => 'tuteurp2@univers-school.com',
                        'password' => Hash::make('password'),
                        'tuteur_id' => 2,
                ]);
                $tuteur2Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur2->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur2->assignRole($tuteur2Role);

                //*Tuteur1 Collège*/
                $tuteur3 = User::create([
                        'email' => 'tuteurc1@univers-school.com',
                        'password' => Hash::make('password'),
                        'tuteur_id' => 3,
                ]);
                $tuteur3Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur3->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur3->assignRole($tuteur3Role);

                //**Tuteur2 Collège*/
                $tuteur4 = User::create([
                        'email' => 'tuteur2@univers-school.com',
                        'password' => Hash::make('password'),
                        'tuteur_id' => 4,
                ]);
                $tuteur4Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur4->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur4->assignRole($tuteur4Role);

                //*Tuteur1 Lycée*/
                $tuteur5 = User::create([
                        'email' => 'tuteurl1@univers-school.com',
                        'password' => Hash::make('password'),
                        'tuteur_id' => 5,
                ]);
                $tuteur5Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur5->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur5->assignRole($tuteur5Role);

                //**Tuteur2 Lycée*/
                $tuteur6 = User::create([
                        'email' => 'tuteurl2@univers-school.com',
                        'password' => Hash::make('password'),
                        'tuteur_id' => 6,
                ]);
                $tuteur6Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur6->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur6->assignRole($tuteur6Role);
                /****************************************  Fin tuteurs******************************************************/


                /****************************************  6 Apprenant-Tuteurs ******************************************************/
                ApprenantTuteur::create([]);

                /****************************************  Apprenant-Tuteurs ******************************************************/
        }
}
