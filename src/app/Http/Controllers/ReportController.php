<?php

namespace App\Http\Controllers;

use App\Http\Traits\CustomResponse;
use App\Models\Invoice;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use CustomResponse;
    private Invoice $invoice;
    public function __construct()
    {
        $this->invoice=new Invoice;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('reports.invoice');
    }
    public function searchRange(Request $request){
        $request->validate([
            'status'=>'required',
            'status.*'=>['required','string','in:all,0,1,2,archive'],
            'rangeStart'=>'required|date',
            'rangeEnd'=>'required|date',
        ]);
        //search in all invoices
        $data= null;
        if(in_array('all',$request->status)){
            $data=$this->invoice::whereBetween('invoice_date',[$request->rangeStart,$request->rangeEnd])->get();
        }else{
            if(in_array('archive',$request->status)){
                if(count($request->status)===1){
                    //only archived choosed
                    $data=$this->invoice::where('deleted_at','!=',null)
                            ->whereBetween('invoice_date',[$request->rangeStart,$request->rangeEnd])->get();
                }
                else
                    $data=$this->invoice::where('deleted_at','!=',null)
                            ->whereBetween('invoice_date',[$request->rangeStart,$request->rangeEnd])
                            ->where(function($query)use($request) {
                                $query->orWhere('status',$request->status[0]??null)
                                ->orWhere('status',$request->status[1]??null)
                                ->orWhere('status',$request->status[2]??null)
                                ->orWhere('status',$request->status[3]??null)
                                ->orWhere('status',$request->status[4]??null);
                            })
                            ->get();
            }else{
                $data=$this->invoice::where('deleted_at',null)
                            ->whereBetween('invoice_date',[$request->rangeStart,$request->rangeEnd])
                            ->where(function($query)use($request) {
                                $query->where('status',$request->status[0]??null)
                                ->orWhere('status',$request->status[1]??null)
                                ->orWhere('status',$request->status[2]??null)
                                ->orWhere('status',$request->status[3]??null)
                                ->orWhere('status',$request->status[4]??null);
                            })
                            ->get();

            }
        }
        if($data)
            return  back()->with('invoices',$data);
        //if no data found
        return  back()->with('nullResult',true);

    }
    public function searchNumber(Request $request){
        $request->validate([
            'invoice_number'=>['required','string','max:255']
        ]);
        $invoice=$this->invoice::where('invoice_number',$request->invoice_number)->get();
        // dd($invoice->isEmpty());
        if(!$invoice->isEmpty())
            return back()->with('invoices',$invoice);
        return  back()->with('nullResult',true);
    }

}
