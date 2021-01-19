<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    private Role $role;
    public function __construct()
    {
        $this->role=new Role;
        $this->permission=new Permission();
    }
    public function index(){
        $roles=$this->role::paginate(20);
        return view('user.roles',['roles'=>$roles]);
    }
    public function show(int $id){

        $role=$this->role::with('users')->findOrFail($id);
        $role->givePermissionTo('edit invoices');
        $permissions=$this->permission::all()->pluck('name');
        return view('user.show_role',['role'=>$role,'permissions'=>$permissions]);
    }
    public function store(Request $request){
        $request->validate([
            'name'=>['string','required','unique:roles,name']
        ]);
        $this->role::create([
            'name'=>$request->name
        ]);
        return back()->with('success','successfully created the role');
    }
    public function update(Request $request){
        $request->validate([
            'name'=>['required','string'],
            'permissions.*'=>['nullable','string','exists:permissions,name'],
            'id'=>['required','numeric']
        ]);
        $role=$this->role::with('permissions')->findOrFail($request->id);
        //remove old permissions
        foreach ($role->permissions as $permission ) {
            $role->revokePermissionTo($permission);
        }
        //assign the new permissions
        foreach($request->permissions as $permission){
            $role->givePermissionTo($permission);
        }

        //update the name
        $this->role::findOrFail($request->id)->update([
            'name'=>$request->name,
            'updated_at'=>now()
        ]);
        return back()->with('success','successfully updated');
    }
    public function destroy(Request $request){
        $request->validate([
            'id'=>['required','numeric']
        ]);
        $this->role::findOrFail($request->id)->delete();
        return back()->with('success','succcessfully deleted');
    }


}
