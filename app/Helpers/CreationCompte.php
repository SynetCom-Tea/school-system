<?php

use App\Models\Role;
use App\Models\User;
use App\Models\Permission;
use App\Models\SectionUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

// namespace App\Helpers;
/**
 * Write code on Method
 *
 * @return response()
 */
if (!function_exists('CreationCompte')) {
    function CreationCompte($item_apprenant = null, $section = null, $type_user = null, $role = null, $request = null)
    {
        $user = Auth::user();

        $nom = $item_apprenant ? str_replace(' ', '', $item_apprenant->nom) : str_replace(' ', '', $request->nom);
        $prenom = $item_apprenant ? str_replace(' ', '', $item_apprenant->prenom) : str_replace(' ', '', $request->prenom);
        $login = strtolower($nom) . '-' . strtolower($prenom) . '@gmail.com';
        $data = [
            'nom' => $item_apprenant ? $item_apprenant->nom : $request->nom,
            'prenom' => $item_apprenant ? $item_apprenant->prenom : $request->prenom,
            'type_user' => $type_user,
            'email' => $login,
            'user_id' => $user->id,
            'password' => Hash::make($login),
            'etablissement_id' => $user->etablissement_id,
        ];
        if ($type_user == 'Etudiant') {
            $data['apprenant_id'] = $item_apprenant->id;
        } else if ($request->type_user == 'Tuteur' || $request->type_user == 'Enseignant') {
            $data[strtolower($request->type_user) . '_id'] = $request->{strtolower($request->type_user) . '_id'};
        }
        $userCreate = User::create($data);
        if ($role != null) {
            $permis = Role::find($role);
            $userCreate->syncRoles($role);
            $userCreate->syncPermissions($permis->permissions->pluck('id'));
        } else if ($role == null && $type_user == 'Etudiant') {
            $permission = Permission::where('name', 'espace_etudiant')->get()[0]->id;
            $userCreate->syncPermissions($permission);
        }
        if ($request != null) {
            if ($request->checkbox != null) {
                foreach ($request->section as $sec) {
                    $etablissement_sections = getSectionEtablissement($user->etablissement_id, $sec);
                    SectionUser::create([
                        'user_id' => $userCreate->id,
                        'etablissement_section_id' => $etablissement_sections[0]
                    ]);
                }
            }
        }
    }
}
