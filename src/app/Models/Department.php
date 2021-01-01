<?php

namespace App\Models;

use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Department extends Model
{
    use HasFactory;
    /**
     *
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['title','description','created_by','created_at', 'updated_at', 'deleted_at'];
    public function product()
    {
        return $this->hasMany(Product::class);
    }
}
