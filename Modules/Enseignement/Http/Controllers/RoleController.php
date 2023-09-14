<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use App\Models\PermissionRole;
use Illuminate\Support\Facades\DB;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
    $user = Auth::user();
    $tabs = [];
    $all = [];
    $roles = Role::has('permission_roles')->get();
        foreach ($roles as  $role) {
            $yy = PermissionRole::where('user_id',$user->id)->where('role_id',$role->id)->with('permission')->get();
            if($yy->count() != 0){
                // $key = $key - 1;
                $tabs = [
                    'role' => $role,
                    'permissions' => $yy
                ];
                $all[] = $tabs ;
                
            } 
        }
        // dd($all);
    $permissions = Permission::with('permission_roles.user','permission_roles.role')->get();
    $permission = $request->role ? Permission::whereHas('permission_roles.user', function ($query) use($user){
            $query->where('id',1);})->whereHas('permission_roles.role', function ($query) use($request){
            $query->where('id',$request->role);})->with('permission_roles.role')->get() : collect();
        return Inertia::render('Enseignement/Configs/Role', [
            'permission_role_users' => $all,
            'roles'=>Role::all(),
            'permissions' => $permissions,
            'permission'=>$permission
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
    public function store(Request $request)
    {
        $role = Role::find($request->role_id);
        if (PermissionRole::where('role_id',$role->id)->where('user_id',Auth::user()->id)->exists()){
        return redirect()->back()->with('messages', 'Ce rôle existe déjâ!');
        }else {
            foreach($request->permissions as $permssion){
                PermissionRole::create([
                    'user_id' => Auth::user()->id,
                    'role_id'=>$role->id,
                    'permission_id' => $permssion
                ]);
            }
        return redirect()->back()->with('message', 'Rôle créé avec succès!');
        }
        
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
        foreach($request->permissions as $permssion){
            $permssion_roles = PermissionRole::
                PermissionRole::update([
                    'user_id' => Auth::user()->id,
                    'role_id'=>$role->id,
                    'permission_id' => $permssion
                ]);
            }
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
