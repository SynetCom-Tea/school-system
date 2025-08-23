<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Validation\ValidatesRequests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
        $permissions = [];
        if($request->section_id == 1 || $request->section_id == 2){
            $permissions = DB::table('permissions')
                ->where('name', '<>', 'manage_welcome')
                ->where('name', '<>', 'manage_system')
                ->where('section_id', '=', null)->get();
        }
        if($request->section_id == 3){
            $permissions = DB::select(" SELECT *
                FROM permissions  WHERE name <> 'manage_welcome'
                AND name <> 'manage_system'");
        }
        $all = [];
        $roles = Role::with(['permissions'])->whereIn('etablissement_section_id', $etablissement_section)->get();
        // dd($roles);
        return Inertia::render('Enseignement/Configs/Role', [
            'section_id' => $request->section_id,
            'permission_role_users' => $all,
            'allRoles' => $roles,
            'Allpermissions' => $permissions
        ]);
    }
    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
   
    // public function store(Request $request)
    // {
    //     $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);
    //     // dd($request->all(), $request->section_id);
    //     $data = $this->validate($request, [
    //         'name' => 'required|string',
    //     ]);
    //     $data['etablissement_section_id'] = $etablissement_section[0];
    //     $permissions = $this->validate($request, [
    //         'permissions' => 'required'
    //     ]);
    //     // dd($data, $permissions);
    //     $role = Role::create($data);
    //     $role->syncPermissions($permissions);
    //     // $role = Role::find($request->role_id);
    //     return redirect()->back()->with('message', 'Rôle créé avec succès!');
    //     // if (PermissionRole::where('role_id', $role->id)->where('user_id', Auth::user()->id)->exists()) {
    //     //     return redirect()->back()->with('messages', 'Ce rôle existe déjâ!');
    //     // } else {
    //     //     foreach ($request->permissions as $permssion) {
    //     //         PermissionRole::create([
    //     //             'user_id' => Auth::user()->id,
    //     //             'role_id' => $role->id,
    //     //             'permission_id' => $permssion
    //     //         ]);
    //     //     }
            
    //     // }
    // }

 public function store(Request $request)
    {
        $etablissement_section = getSectionEtablissement(Auth::user()->etablissement_id, $request->section_id);

        // VALIDATION PERSONNALISÉE
        $validator = Validator::make($request->all(), [
            'name' => [
                'required',
                'string',
                function ($attribute, $value, $fail) use ($etablissement_section) {
                    // Vérifie si un rôle avec le même nom existe pour le MÊME établissement
                    $existingRole = Role::where('name', $value)
                                        ->where('etablissement_section_id', $etablissement_section[0])
                                        ->first();
                    
                    if ($existingRole) {
                        $fail('Un rôle avec ce nom existe déjà pour cet établissement.');
                    }
                }
            ],
            'permissions' => 'required|array'
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                             ->withErrors($validator)
                             ->withInput();
        }

        $data = [
            'name' => $request->name,
            'etablissement_section_id' => $etablissement_section[0],
            'guard_name' => 'web'
        ];

        $role = Role::create($data);
        $role->syncPermissions($request->permissions);

        return redirect()->back()->with('message', 'Rôle créé avec succès!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $permission_roles = PermissionRole::where('user_id', Auth::user()->id)->where('role_id', $id)->get();

        foreach ($permission_roles as $permission_role) {
            // dd($permission_role->id);
            $permission_role_users = PermissionRole::find($permission_role->id);
            // dump($permission_role_users->id);
            foreach ($request->permissions as $permission) {
                $permission_role_users->updateOrCreate([
                    'user_id' => Auth::user()->id,
                    'role_id' => $request->role,
                    'permission_id' => $permission
                ]);
            }
        } // die();
    }
    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $role = Role::find($id);
        $role->delete();
        return redirect()->back();
    }
}
