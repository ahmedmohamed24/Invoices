<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Models\Department as DepartmentModel;

trait Department{
    private DepartmentModel $department;
    private Validator $validator;
    public function __construct(DepartmentModel $department,Validator $validator){
        $this->department=$department;
        $this->validator=$validator;
    }
    public function validateDepartment(Request $request){
        return Validator::make($request->all(),[
            'title'=>'required|string|max:50',
            'description'=>'nullable|string'
        ]);
    }
    public function createDepartment(Request $request){
        $this->department::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'created_by'=>Auth::id(),
            'created_at'=>now(),
            'updated_at'=>now()
        ]);
    }
}

