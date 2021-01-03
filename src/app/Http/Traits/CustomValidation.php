<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

trait CustomValidation{
    public function validateProduct(Request $request){
        return Validator::make($request->all(),[
            'title'=>'required|string|max:255',
            'description'=>'required|string',
            'img'=>'nullable|image|mimes:png,jpg,jpeg|max:1024',
            'price'=>'required|numeric|min:0|max:999999.99',
            'department'=>"required|exists:departments,id",
        ]);
    }
}
