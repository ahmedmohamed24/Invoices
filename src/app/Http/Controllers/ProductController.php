<?php

namespace App\Http\Controllers;

use App\Http\Traits\CustomResponse;
use App\Http\Traits\Product as ProductTrait;
use App\Http\Traits\UploadImage;
use App\Models\Department;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    use UploadImage;
    use ProductTrait;
    use CustomResponse;
    private Product $product;
    private Department $department;

    public function __construct()
    {
        $this->product = new Product();
        $this->department = new Department();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = $this->product::select('id', 'img', 'description', 'title', 'department_id', 'price')->where('deleted_at', null)->paginate(10);
        $departments = $this->department->select('id', 'title')->get();

        return view('settings.products', ['products' => $products, 'departments' => $departments]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('404');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $isValid = $this->validateProduct($request);
        if ($isValid->fails()) {
            return $this->customResponse(406, $isValid->errors(), null);
        }
        $newImageName = null;
        if ($request->hasFile('img')) {
            //the user uploaded an image for product
            $newImageName = $this->customUpload($request->file('img'));
        }
        $this->createProduct($request, $newImageName);

        return $this->customResponse(200, "product {$request->title} Uploaded");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function show(int $id)
    {
        $product = $this->product::where('deleted_at', null)->findOrFail($id);

        return $this->customResponse(200, 'success', $product);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        return view('404');
    }

    public function update(Product $product)
    {
        return redirect(route('product.update'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function customUpdate(Request $request)
    {
        $isValid = $this->validateProduct($request);
        if ($isValid->fails()) {
            return $this->customResponse(406, $isValid->errors(), null);
        }
        $oldProductData = $this->product::where('deleted_at', null)->findOrFail($request->product);

        $newImageName = null;
        //check if the product has new image or not
        if (null !== $request->img) {
            //check if the product had a previous image
            if ('assets/img/ecommerce/01.jpg' !== $oldProductData->img) {
                //delete the old one
                unlink(public_path($oldProductData->img));
            }
            $newImageName = $this->customUpload($request->file('img'));
        }
        //update using custom trait
        $this->updateProduct($request, $newImageName);

        return $this->customResponse(200, "product /{$request->title}/ updated, please reload the page to view");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(int $id)
    {
        $this->product::where('deleted_at', null)->findOrFail($id)->update([
            'deleted_at' => now(),
        ]);
        //may delete it's image also
        return redirect()->back()->with('message', 'Product deleted successfully');
    }
}
