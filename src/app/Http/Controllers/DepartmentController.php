<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;
use App\Http\Traits\CustomResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class DepartmentController extends Controller
{
    use CustomResponse;
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
        $validators=Validator::make(
            $request->all(),
            [
                'title'=>'required|string|unique:departments,title|max:50',
                'description'=>'nullable|string'
            ]
        );
        if($validators->fails())
           return $this->customResponse(406,$validators->errors()->all(),null);
        $this->department::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'created_by'=>Auth::id(),
        ]);
        return $this->customResponse(200,"data added successfully");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function show(Department $department)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function edit(int $id)
    {
        $department=$this->department::findOrFail($id);
        return view('settings.departmentEdit',['department'=>$department]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request,$id)
    {
        $request->validate([
            'title'=>'required|string|unique:departments,title|max:50',
            'description'=>'nullable|string'
        ]);
        $this->department::findOrFail($id)->update(['title'=>$request->title,'description'=>$request->description]);
        return redirect()->route('department.index')->with('message',"Department update successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Department  $department
     * @return \Illuminate\Http\Response
     */
    public function destroy(Department $department)
    {
        //
    }
}
