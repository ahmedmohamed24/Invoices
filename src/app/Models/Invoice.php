<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['invoice_number','invoice_date','department','due_date','product','section','deduction','commision_value','vat_value','total','status','user','deleted_at','created_at','created_by','updated_at'];
    //accessors and mutators
    //not paid =0 , paid=1 , partially paid =2
    public function getStatusAttribute($val){
       if($val==0)
        return "not_paid";
       elseif($val==1)
        return "paid";
       else
        return "partially_paid";
    }
    //Relations of the invoice model
    public function user(){
        return $this->belongsTo(\App\Models\User::class,'created_by');
    }
    public function attachments()
    {
        return $this->hasMany(\App\Models\Attachment::class,'invoice_id');
    }
    public function getDepartment(){
        return $this->belongsTo(\App\Models\Department::class,'department');
    }
    public function details(){
        return $this->hasMany(\App\Models\InvoiceDetails::class);
    }
    public function getProduct(){
        return $this->belongsTo(\App\Models\Product::class,'product');
    }
}
