<?php

namespace Modules\Enseignement\Http\Controllers;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $collection = Role::with(['permissions'])->get();
        return Inertia::render('Enseignement/Configs/Role', [
            'roles' => $collection,
            'permissions' => Permission::all()
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
        //dd($request->all());
        // $data = $this->validate($request, [
        //     'name' => 'required',
        // ]);
        // $permission = $this->validate($request, [
        //     'permission' => 'required'
        // ]);
        
        $role = Role::create([
            'name' =>
            $request->name]);
        $role->syncPermissions([
            'permission'=>$request->permission]);
        return redirect()->back()->with('message', [
            'type' => 'success',
            'text' => 'Rôle créé avec succès!',
        ]);
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
        $role = Role::find($id);
        $role->update(['name'=>$request->name]);
        $role->syncPermissions(['permission'=>$request->permission]);
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
