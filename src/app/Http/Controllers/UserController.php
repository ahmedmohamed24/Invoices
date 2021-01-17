<?php

namespace App\Http\Controllers;

use App\Http\Traits\CustomResponse;
use Exception;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

use function PHPUnit\Framework\isEmpty;

class UserController extends Controller
{
    use CustomResponse;
    private Auth $auth;
    private User $user;
    private Role $role;
    private Permission $permission;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct()
    {
        $this->auth=new Auth;
        $this->user=new User;
        $this->role=new Role;
        $this->permission=new Permission;
        if(!$this->auth::check())
             return redirect(route('login'),302,['message'=>'not authenticated']);
    }
    public function index()
    {
        // User::findOrFail(1)->assignRole('admin');
        // User::findOrFail(1)->givePermissionTo('edit articles');
        // Permission::create(['name'=>'write articles']);
        // User::findOrFail(1)->givePermissionTo('write articles');
        // User::findOrFail(1)->revokePermissionTo('write articles');
        $roles=$this->role::all()->pluck('name');
        $permissions=$this->permission::all()->pluck('name');
        $users=$this->user::paginate(10);
        return view('user.users',['users'=>$users,'roles'=>$roles,'permissions'=>$permissions]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>['required','string','max:255','min:2'],
            'email'=>['required','email','unique:users,email','max:255'],
            'password'=>['required_with:cPassword','same:cPassword','min:8'],
            'cPassword'=>['min:8'],
            'status'=>['required','string','in:active,inactive'],
            'roles.*'=>['nullable','string','exists:roles,name'],
            'permissions.*'=>['nullable','string','exists:permissions,name'],
        ]);
        try{
            DB::beginTransaction();
            // save the user to database
            $user=$this->user::create([
                'name'=>$request->name,
                'email'=>$request->email,
                'password'=>Hash::make($request->password),
                'status'=>$request->status
            ]);
            //assign his role
            if($request->roles){
                foreach($request->roles as $role){
                    $user->assignRole($role);
                }
            }
            if($request->permissions){
                foreach($request->permissions as $permission){
                    $user->givePermissionTo($permission);
                }
            }

            DB::commit();
            return back()->with('success','successfully added');

        }catch(Exception $e){
            DB::rollback();
            // abort(404);
            //display only for dubugging
            return back()->with('error',$e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        // $user=$this->user::select(['id','name','email','status'])->findOrFail($id);
        $user=$this->user::select(['id','name','email','status'])->with('roles')->with('permissions')->findOrFail($id);
        return $this->customResponse(200,'success',$user);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        try{
            $this->user::findOrFail($id)->delete();
            return back()->with('success','successfully deleted');
        }catch(Exception $e){
            //only for debugging
            return back()->with('error',$e->getMessage());
        }
    }
}
