<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Product extends Model
{
   use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','price','created_by','deleted_at','description','img','department_id'];

    //accessors and mutators
    public function getImgAttribute($img)
    {
        //to retutn default image when image is null
        if($img)
            return $img;
        return "assets/img/ecommerce/01.jpg";
    }

    //product model relations
    public function invoices(){
        return $this->belongsTo(\App\Models\Invoice::class,'product');
    }
    public function department()
    {
        return $this->belongsTo(\App\Models\Department::class,'department_id');
    }
}
