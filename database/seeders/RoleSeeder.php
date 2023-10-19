<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\ApprenantTuteur;
use App\Models\SectionUser;
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
                        'id' => 1,
                        'nom' => 'Tondi',
                        'prenom' => 'Bouli',
                        'email' => 'super-admin@univers-school.com',
                        'password' => Hash::make('password'),
                        'nom' => 'super',
                        'prenom' => 'Administrateur',
                ]);

                $roles = Role::firstOrcreate(['name' => 'Super-administrateur']);
                $super_admin->givePermissionTo(Permission::where('name', 'manage_system')->get());
                $super_admin->assignRole($roles);

                // Admin
                $admin = User::create([
                        'id' => 2,
                        'email' => 'admin@univers-school.com',
                        'password' => Hash::make('password'),
                        'nom' => 'Admin',
                        'etablissement_id' => 1,
                        'prenom' => 'Etablissement',
                        'user_id' => 1
                ]);

                $role_admin = Role::firstOrcreate(['name' => 'Administrateur']);
                $admin->givePermissionTo(Permission::where('name', '<>','manage_system')->get());
                $admin->assignRole($role_admin);
                /****************************************  2 éléves au collège et 2 au lycée ******************************************************/

                //*Apprenant1 */

                $eleve1 = User::create([
                        'id' => 3,
                        'email' => 'eleve1@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'apprenant_id' => 3,
                        'user_id' => 2


                ]);

                $eleve1Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve1->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve1->assignRole($eleve1Role);

                //*Apprenant2 */

                $eleve2 = User::create([
                        'id' => 4,
                        'email' => 'eleve2@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'apprenant_id' => 4,
                        'user_id' => 2,
                ]);

                $eleve2Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve2->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve2->assignRole($eleve2Role);
                //*Apprenant1 */

                $eleve3 = User::create([
                        'id' => 5,
                        'email' => 'eleve3@univers-school.comm',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'apprenant_id' => 5,
                        'user_id' => 2,

                ]);

                $eleve3Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve3->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve3->assignRole($eleve3Role);

                //*Apprenant4 */

                $eleve4 = User::create([
                        'id' => 6,
                        'email' => 'eleve4@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'apprenant_id' => 6,
                        'user_id' => 2,

                ]);

                $eleve4Role = Role::firstOrcreate(['name' => 'Apprenant']);
                $eleve4->givePermissionTo(Permission::where('name', 'apprenant')->get());
                $eleve4->assignRole($eleve4Role);

                /****************************************  Fin éléves ******************************************************/



                /****************************************  6 Tuteurs ******************************************************/
                //*Tuteur1 Primaire */
                $tuteur1 = User::create([
                        'id' => 7,
                        'email' => 'tuteurp1@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'tuteur_id' => 1,
                        'user_id' => 2,
                ]);
                $tuteur1Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur1->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur1->assignRole($tuteur1Role);

                //**Tuteur2 Primaire*/
                $tuteur2 = User::create([
                        'id' => 8,
                        'email' => 'tuteurp2@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'tuteur_id' => 2,
                        'user_id' => 2,
                ]);
                $tuteur2Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur2->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur2->assignRole($tuteur2Role);

                //*Tuteur1 Collège*/
                $tuteur3 = User::create([
                        'id' => 9,
                        'email' => 'tuteurc1@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'tuteur_id' => 3,
                        'user_id' => 2,
                ]);
                $tuteur3Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur3->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur3->assignRole($tuteur3Role);

                //**Tuteur2 Collège*/
                $tuteur4 = User::create([
                        'id' => 10,
                        'email' => 'tuteur2@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'tuteur_id' => 4,
                        'user_id' => 2,
                ]);
                $tuteur4Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur4->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur4->assignRole($tuteur4Role);

                //*Tuteur1 Lycée*/
                $tuteur5 = User::create([
                        'id' => 11,
                        'email' => 'tuteurl1@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'tuteur_id' => 5,
                        'user_id' => 2,
                ]);
                $tuteur5Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur5->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur5->assignRole($tuteur5Role);

                //**Tuteur2 Lycée*/
                $tuteur6 = User::create([
                        'id' => 12,
                        'email' => 'tuteurl2@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'tuteur_id' => 6,
                        'user_id' => 2,
                ]);
                $tuteur6Role = Role::firstOrcreate(['name' => 'Tuteur']);
                $tuteur6->givePermissionTo(Permission::where('name', 'tuteur')->get());
                $tuteur6->assignRole($tuteur6Role);
                /****************************************  Fin tuteurs******************************************************/

                /****************************************  Début 3 Enseignants*****************************************************/

                //**Enseignant1 Primaire et secondaire*/
                $enseignant1 = User::create([
                        'id' => 13,
                        'email' => 'enseignant1@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'enseignant_id' => 1,
                        'user_id' => 2,
                ]);
                $enseignant1Role = Role::firstOrcreate(['name' => 'Enseignant']);
                $enseignant1->givePermissionTo(Permission::where('name', 'enseignant')->get());
                $enseignant1->assignRole($enseignant1Role);

                //**Enseignant2 Collège*/
                $enseignant2 = User::create([
                        'id' => 14,
                        'email' => 'enseignant2@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'enseignant_id' => 2,
                        'user_id' => 2,
                ]);
                $enseignant2Role = Role::firstOrcreate(['name' => 'Enseignant']);
                $enseignant2->givePermissionTo(Permission::where('name', 'enseignant')->get());
                $enseignant2->assignRole($enseignant2Role);

                //**Enseignant3 Lycée*/
                $enseignant3 = User::create([
                        'id' => 15,
                        'email' => 'enseignant3@univers-school.com',
                        'password' => Hash::make('password'),
                        'etablissement_id' => 1,
                        'enseignant_id' => 3,
                        'user_id' => 2,
                ]);
                $enseignant3Role = Role::firstOrcreate(['name' => 'Enseignant']);
                $enseignant3->givePermissionTo(Permission::where('name', 'enseignant')->get());
                $enseignant3->assignRole($enseignant3Role);
                /****************************************  Fin Enseignants*****************************************************/

                /****************************************  6 section_users ******************************************************/

                SectionUser::create([
                        'user_id' => 3, 'etablissement_section_id' => 2,
                ]);
                SectionUser::create([
                        'user_id' => 4, 'etablissement_section_id' => 2,
                ]);

                SectionUser::create([
                        'user_id' => 5, 'etablissement_section_id' => 2,
                ]);

                SectionUser::create([
                        'user_id' => 6, 'etablissement_section_id' => 2,
                ]);

                SectionUser::create([
                        'user_id' => 7, 'etablissement_section_id' => 1,
                ]);

                SectionUser::create([
                        'user_id' => 8, 'etablissement_section_id' => 1,
                ]);

                SectionUser::create([
                        'user_id' => 9, 'etablissement_section_id' => 2,
                ]);

                SectionUser::create([
                        'user_id' => 10, 'etablissement_section_id' => 2,
                ]);

                SectionUser::create([
                        'user_id' => 11, 'etablissement_section_id' => 2,
                ]);
                SectionUser::create([
                        'user_id' => 12, 'etablissement_section_id' => 2,
                ]);
                SectionUser::create([
                        'user_id' => 13, 'etablissement_section_id' => 1,
                ]);
                SectionUser::create([
                        'user_id' => 13, 'etablissement_section_id' => 2,
                ]);

                SectionUser::create([
                        'user_id' => 14, 'etablissement_section_id' => 2,
                ]);
                SectionUser::create([
                        'user_id' => 15, 'etablissement_section_id' => 2,
                ]);

                /****************************************  Fin section_users ******************************************************/

                /****************************************  6 Apprenant-Tuteurs ******************************************************/
                \DB::table('apprenant_tuteurs')->insert(array(
                        0 =>
                        array(
                                'apprenant_id' => 1,
                                'tuteur_id' => 1,
                        ),
                        1 =>
                        array(
                                'apprenant_id' => 2,
                                'tuteur_id' => 2,
                        ),
                        2 =>
                        array(
                                'apprenant_id' => 3,
                                'tuteur_id' => 3,
                        ),
                        3 =>
                        array(
                                'apprenant_id' => 4,
                                'tuteur_id' => 4,
                        ),
                        4 =>
                        array(
                                'apprenant_id' => 5,
                                'tuteur_id' => 5,
                        ),

                        5 =>
                        array(
                                'apprenant_id' => 6,
                                'tuteur_id' => 6,
                        ),

                ));


                /**************************************** Fin Apprenant-Tuteurs ******************************************************/



                /****************************************  6 Inscriptions ******************************************************/
                // \DB::table('inscriptions')->insert(array(
                //         0 =>
                //         array(
                //                 'id' => 1,
                //                 'apprenant_id' => 1,
                //                 'date_inscription' => "2023-09-22 09:45:24",
                //         ),
                //         1 =>
                //         array(
                //                 'id' => 2,
                //                 'apprenant_id' => 2,
                //                 'date_inscription' => "2023-09-22 09:45:24",
                //         ),
                //         2 =>
                //         array(
                //                 'id' => 3,
                //                 'apprenant_id' => 3,
                //                 'date_inscription' => "2023-09-22 09:45:24",
                //         ),
                //         3 =>
                //         array(
                //                 'id' => 4,
                //                 'apprenant_id' => 4,
                //                 'date_inscription' => "2023-09-22 09:45:24",
                //         ),
                //         4 =>
                //         array(
                //                 'id' => 5,
                //                 'apprenant_id' => 5,
                //                 'date_inscription' => "2023-09-22 09:45:24",
                //         ),

                //         5 =>
                //         array(
                //                 'id' => 6,
                //                 'apprenant_id' => 6,
                //                 'date_inscription' => "2023-09-22 09:45:24",
                //         ),

                // ));


                /**************************************** Fin inscriptions ******************************************************/
        }
}
