<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Modules\Scolarite\Entities\Tuteur;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class TuteursSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {


        /****************************************  2 Tuteurs  du primaire******************************************************/
        //*Tuteur1 */
        Tuteur::create([
            'mail' => 'tchimba@gmail.com',
            'nom' => 'tuteur1',
            'prenom' => 'Tchimba',
            'adresse' => "Saga",
            'telephone' => "80808080"

        ]);

        //**Tuteur2 */
        Tuteur::create([
            'mail' => 'fanta@yahoo.com',
            'nom' => 'tuteur2',
            'prenom' => 'Fanta',
            'adresse' => "Plateau",
            'telephone' => "82808080"
        ]);

        /****************************************  Fin  Tuteurs  du primaire******************************************************/


        /****************************************  2 Tuteurs  du Collège*****************************************************/
        //*Tuteur3 */

        Tuteur::create([
            'mail' => 'ahmed@gmail.com',
            'nom' => 'tuteur3',
            'prenom' => 'Ahmed',
            'adresse' => "Yantala",
            'telephone' => "88808080"

        ]);
        //**Tuteur4 */
        Tuteur::create([
            'mail' => 'maimouna@gmail.com',
            'nom' => 'tuteur4',
            'prenom' => 'Maimouna',
            'adresse' => "Lakouroussou",
            'telephone' => "94808080"
        ]);


        /****************************************  Fin Tuteurs  du Collège******************************************************/


        /****************************************  2 Tuteurs  du Lycée******************************************************/
        //*Tuteur5 */

        Tuteur::create([
            'mail' => 'mamoudou@gmail.com',
            'nom' => 'tuteur5',
            'prenom' => 'Mamoudou',
            'adresse' => "Yantala",
            'telephone' => "90808080"

        ]);
        //**Tuteur6 */
        Tuteur::create([
            'mail' => 'mouna@gmail.com',
            'nom' => 'tuteur6',
            'prenom' => 'Mouna',
            'adresse' => "Goudel",
            'telephone' => "92808080"
        ]);


        /****************************************  Fin Tuteurs  du Lycée******************************************************/
    }
}
