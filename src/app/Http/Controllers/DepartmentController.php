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
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
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
    public function update(Request $request)
    {
        dd($request);
        $request->validate([
            'department'=>"required|numeric",
            'title'=>"required|string|max:50",
            'description'=>'nullable|string'
        ]);
        $isUnique=$this->department::select('*')->where('title',$request->title)->where('id','!=',$request->department)->count();
        if($isUnique!=0)
            return redirect()->back()->with('msg','Title is already taken');
        $this->department::findOrFail($request->product)->update(['title'=>$request->title,'description'=>$request->description,'updated_at'=>now()]);
        return redirect(route('department.index'))->with('message',"Department update successfully");
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
