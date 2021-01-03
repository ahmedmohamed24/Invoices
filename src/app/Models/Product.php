<?php

namespace App\Models;

use App\Models\Department;
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
    protected $fillable = ['title','price','created_by','description','img','department_id'];
    public function department()
    {
        return $this->belongsTo(Department::class,'department_id');
    }
    /**
     * Get the
     *
     * @param  string  $value
     * @return string
     */
    public function getImgAttribute($img)
    {
        //to retutn default image when image is null
        if($img)
            return $img;
        return "assets/img/ecommerce/01.jpg";
    }
}
