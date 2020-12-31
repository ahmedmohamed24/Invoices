<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
