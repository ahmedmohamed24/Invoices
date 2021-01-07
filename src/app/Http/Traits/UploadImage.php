<?php

namespace App\Http\Traits;

trait UploadImage{
    public function customUpload($img):string{
        $ext=$img->getClientOriginalExtension();
        $newImageName="product".now().uniqid().".$ext";
        $img->move(public_path('uploads/products'),$newImageName);
        return "/uploads/products/$newImageName";
    }
    public function uploadAttachment($img):string{
        $ext=$img->getClientOriginalExtension();
        $newImageName="product".now().uniqid().".$ext";
        $img->move(public_path('uploads/invoices'),$newImageName);
        return "/uploads/invoices/$newImageName";
    }
}
