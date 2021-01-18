<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    private Role $role;
    public function __construct()
    {
        $this->role=new Role;
    }
    public function index(){
        $roles=$this->role::paginate(20);
        return view('user.roles',['roles'=>$roles]);
    }
    public function show(int $id){
        $role=$this->role::with('users')->findOrFail($id);
        return view('user.show_role',['role'=>$role]);
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
            'name'=>['required','string','unique:roles,name'],
            'id'=>['required','numeric']
        ]);
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
