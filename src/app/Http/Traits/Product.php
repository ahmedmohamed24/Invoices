<?php
namespace App\Http\Traits;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product as ProductModel;
use Illuminate\Support\Facades\Validator;

trait Product{
    private ProductModel $product;
    public function __construct(ProductModel $product){
        $this->product=$product;
    }
    public function createProduct(Request $request,string $image=null){
        $this->product::create([
            'title'=>$request->title,
            'description'=>$request->description,
            'price'=>$request->price,
            'created_by'=>Auth::user()->id,
            'img'=>$image,
            'department_id'=>$request->department,
            'updated_at'=>now(),
            'created_at'=>now(),
        ]);
    }
    public function updateProduct(Request $request,string $imageName=null){
        $this->product::findOrFail($request->product)->update([
                'title'=>$request->title,
                'description'=>$request->description,
                'price'=>$request->price,
                'created_by'=>Auth::user()->id,
                'img'=>$imageName,
                'department_id'=>$request->department,
                'updated_at'=>now(),
        ]);
   }
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
