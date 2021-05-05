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
    protected $fillable = ['invoice_id', 'due_date', 'total', 'details', 'status', 'created_by', 'note', 'created_at', 'updated_at'];
    protected $dates = ['due_date'];

    public function invoice()
    {
        return $this->belongsTo(App\Models\Invoice::class, 'invoice_id');
    }

    //accessors and mutators
    //not paid =0 , paid=1 , partially paid =2
    public function getStatusAttribute($val)
    {
        if (0 == $val) {
            return 'not_paid';
        }
        if (1 == $val) {
            return 'paid';
        }

        return 'partially_paid';
    }

    public function user()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }
}
