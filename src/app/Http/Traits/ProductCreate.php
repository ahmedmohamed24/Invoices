<?php
namespace App\Http\Traits;


use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

trait ProductCreate{
    private Product $product;
    public function __construct(Product $product){
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
}
