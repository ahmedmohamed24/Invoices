<?php

namespace App\Http\Controllers;

use App\Http\Traits\CustomResponse;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    use CustomResponse;
    private Product $product;
    private Department $department;
    public function __construct(Product $product,Department $department)
    {
       $this->product=$product;
       $this->department=$department;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
       $products=$this->product::select('id','img','description','title','department_id','price')->paginate(20);
       $departments=$this->department->select('id','title')->get();
       return view('settings.products',['products'=>$products,"departments"=>$departments]);
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
        $validators=Validator::make($request->all(),
            [
                'title'=>'required|string|max:255',
                'description'=>'string|required',
                'img'=>'nullable|image|mimes:png,jpg,jpeg|max:1024',
                'price'=>'required|numeric|min:0|max:999999.99',
                'department'=>"exists:departments,id|required",
                'create_at'=>now(),
                'updated_at'=>now()

            ]
        );
        if($validators->fails())
            return $this->customResponse(406,$validators->errors(),null);
        if($request->img===null){
            //no image uploaded so upload default one
            $this->product::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'price'=>$request->price,
                'created_by'=>Auth::user()->id,
                'img'=>'assets/img/ecommerce/01.jpg',
                'department'=>$request->department_id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }else{
            //the user uploaded image for product
            $img=$request->file('img');
            $ext=$img->getClientOriginalExtension();
            $newImageName='product'.now().uniqid().".$ext";
            $img->move(public_path('/uploads/products',$newImageName));
            $this->product::create([
                'title'=>$request->title,
                'description'=>$request->description,
                'price'=>$request->price,
                'created_by'=>Auth::user()->id,
                'img'=>"/uploads/products/$newImageName",
                'department_id'=>$request->department_id,
                'created_at'=>now(),
                'updated_at'=>now(),
            ]);
        }
        $this->customResponse(200,"product $request->title Uploaded");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        //
    }
}
