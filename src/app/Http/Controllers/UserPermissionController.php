<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Spatie\Permission\Models\Permission;

class UserPermissionController extends Controller
{
    private Permission $permission;
    private Auth $auth;

    public function __construct()
    {
        $this->permission = new Permission();
        $this->auth = new Auth();
    }

    public function index()
    {
        if (!$this->auth::user()->hasPermissionTo('view_permissions')) {
            abort(404);
        }
        $permissions = $this->permission::paginate(10);

        return view('user.permissions', ['permissions' => $permissions]);
    }

    public function show(int $id)
    {
        if (!$this->auth::user()->hasPermissionTo('view_permissions')) {
            abort(404);
        }
        $permission = $this->permission::with('users')->findOrFail($id);

        return view('user.show_permission', ['permission' => $permission]);
    }

    public function store(Request $request)
    {
        if (!$this->auth::user()->hasPermissionTo('add_permission')) {
            abort(404);
        }
        $request->validate([
            'name' => ['string', 'required', 'unique:permissions,name'],
        ]);
        $this->permission::create([
            'name' => $request->name,
        ]);

        return back()->with('success', 'successfully created the permission');
    }

    public function update(Request $request)
    {
        if (!$this->auth::user()->hasPermissionTo('edit_permission')) {
            abort(404);
        }
        $request->validate([
            'name' => ['required', 'string', 'unique:permissions,name'],
            'id' => ['required', 'numeric'],
        ]);
        $this->permission::findOrFail($request->id)->update([
            'name' => $request->name,
            'updated_at' => now(),
        ]);

        return back()->with('success', 'successfully updated');
    }

    public function destroy(Request $request)
    {
        if (!$this->auth::user()->hasPermissionTo('remove_permission')) {
            abort(404);
        }
        $request->validate([
            'id' => ['required', 'numeric'],
        ]);
        $this->permission::findOrFail($request->id)->delete();

        return back()->with('success', 'succcessfully deleted');
    }
}
