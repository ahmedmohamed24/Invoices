<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Traits\Department as DepartmentTrait;
use App\Http\Traits\CustomResponse;
use Illuminate\Support\Facades\Auth;

class DepartmentController extends Controller
{
    use CustomResponse,DepartmentTrait;
    private Department $department;
    public function __construct(Department $department)
    {
        $this->department=$department;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $departments=$this->department::select('id','title','description')->where('deleted_at',NULL)->paginate(20);
        return view('settings.departments',['departments'=>$departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return redirect(route('department.index'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isValid=$this->validateDepartment($request);
        if($isValid->fails())
           return $this->customResponse(406,$isValid->errors()->all(),null);
        $this->createDepartment($request);

        return $this->customResponse(200,"data added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $department=$this->department::findOrFail($id);
        return $this->customResponse(200,"success",$department);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        return redirect(route('department.index'));
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Traits\CustomResponse
     */
    public function customUpdate(Request $request)
    {
        $isValid=$this->validateDepartment($request);
        if($isValid->fails()){
            return $this->customResponse(406,$isValid->errors(),null);
        }
        $isUnique=$this->department::select('*')->where('title',$request->title)->where('id','!=',$request->department)->count();
        if($isUnique!=0)
            return $this->customResponse(406,'Title is already taken',null);
        $this->department::findOrFail($request->department)->update(['title'=>$request->title,'description'=>$request->description,'updated_at'=>now()]);
        return $this->customResponse(200,'Department update successfully, reload to view changes',null);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
       $this->department::findOrFail($id)->delete();
       return redirect()->back()->with('message','Department deleted successfully');
    }
}
