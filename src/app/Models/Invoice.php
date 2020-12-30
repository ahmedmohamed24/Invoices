<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;
    protected $fillable=['invoice_number','invoice_date','due_date','product','section','discount','vat_rate','vat_value','total','status','note','user','deleted_at','created_at','updated_at'];
    //not paid =0 , paid=1 , partially paid =2
    public function getStatusAttribute($val){
       if($val==0)
        return "not_paid";
       elseif($val==1)
        return "paid";
       else
        return "partially_paid";
    }
    public function setStatusAttribute($val){
       if($val=="not_paid")
        $this->status=0;
       elseif($val=="paid")
        $this->status=1;
       else
        $this->status=2;
    }
}
