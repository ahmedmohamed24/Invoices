<?php

namespace App\Http\Traits;

use Illuminate\Support\Facades\Storage;

trait UploadImage{
    public function customUpload($img):string{
        $ext=$img->getClientOriginalExtension();
        $newImageName="product".now().uniqid().".$ext";
        $img->move(public_path('uploads/products'),$newImageName);
        return "/uploads/products/$newImageName";
    }
    public function uploadAttachment($img):string{
        $ext=$img->getClientOriginalExtension();
        $newImageName="invoice-".now().uniqid().".$ext";
        // $img->move(public_path('storage/uploads/invoices'),$newImageName);
        $img->storeAs('/',$newImageName);
        return "$newImageName";
    }
}
