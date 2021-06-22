<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class UserRoleController extends Controller
{
    private Role $role;
    private Auth $auth;

    public function __construct()
    {
        $this->role = new Role();
        $this->auth = new Auth();
        $this->permission = new Permission();
    }

    public function index()
    {
        if (!$this->auth::user()->hasPermissionTo('view_roles')) {
            abort(404);
        }
        $roles = $this->role::paginate(20);

        return view('user.roles', ['roles' => $roles]);
    }

    public function show(int $id)
    {
        if (!$this->auth::user()->hasPermissionTo('view_roles')) {
            abort(404);
        }
        $role = $this->role::with('users')->findOrFail($id);
        if ($this->auth::user()->hasPermissionTo('view_permissions')) {
            $permissions = $this->permission::all()->pluck('name');
        }

        return view('user.show_role', ['role' => $role, 'permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        if (!$this->auth::user()->hasPermissionTo('add_role')) {
            abort(404);
        }
        $request->validate([
            'name' => ['string', 'required', 'unique:roles,name'],
        ]);
        $this->role::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'successfully created the role');
    }

    public function update(Request $request)
    {
        if (!$this->auth::user()->hasPermissionTo('edit_roles')) {
            abort(404);
        }
        $request->validate([
            'name' => ['required', 'string'],
            'permissions.*' => ['nullable', 'string', 'exists:permissions,name'],
            'id' => ['required', 'numeric'],
        ]);
        $role = $this->role::with('permissions')->findOrFail($request->id);
        //remove old permissions
        collect($role->permissions)->map(fn ($permission) => $role->revokePermissionTo($permission));

        //assign the new permissions
        collect($request->permissions)->map(fn ($permission) => $role->givePermissionTo($permission));
        //update the name
        $this->role::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'successfully updated');
    }

    public function destroy(Request $request)
    {
        if (!$this->auth::user()->hasPermissionTo('delete_role')) {
            abort(404);
        }
        $request->validate([
            'id' => ['required', 'numeric'],
        ]);
        $this->role::findOrFail($request->id)->delete();

        return back()->with('success', 'succcessfully deleted');
    }
}
