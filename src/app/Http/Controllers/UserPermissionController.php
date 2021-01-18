<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    private Permission $permission;
    public function __construct()
    {
        $this->permission=new Permission;
    }
    public function index(){
        $permissions=$this->permission::paginate(20);
        return view('user.permissions',['permissions'=>$permissions]);
    }
    public function show(int $id){
        $permission=$this->permission::with('users')->findOrFail($id);
        return view('user.show_permission',['permission'=>$permission]);
    }
    public function store(Request $request){
        $request->validate([
            'name'=>['string','required','unique:permissions,name']
        ]);
        $this->permission::create([
            'name'=>$request->name
        ]);
        return back()->with('success','successfully created the permission');
    }
    public function update(Request $request){
        $request->validate([
            'name'=>['required','string','unique:permissions,name'],
            'id'=>['required','numeric']
        ]);
        $this->permission::findOrFail($request->id)->update([
            'name'=>$request->name,
            'updated_at'=>now()
        ]);
        return back()->with('success','successfully updated');
    }
    public function destroy(Request $request){
        $request->validate([
            'id'=>['required','numeric']
        ]);
        $this->permission::findOrFail($request->id)->delete();
        return back()->with('success','succcessfully deleted');
    }

}
