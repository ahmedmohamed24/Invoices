<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['invoice_id','due_date','total','details','status','created_by','note','created_at','updated_at'];
    public function invoice()
    {
        return $this->belongsTo(App\Models\Invoice::class,'invoice_id');
    }
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
    public function user(){
        return $this->belongsTo(\App\Models\User::class,'created_by');
    }
}
