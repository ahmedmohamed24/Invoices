<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use Illuminate\Http\Request;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private Invoice $invoice;
    public function __construct(Invoice $invoice)
    {
        $this->invoice=$invoice;
    }
    public function index()
    {
        $invoices=$this->invoice::select('invoice_number','user','product','section','total','status')->paginate(30);
        return view('invoices.invoices',['invoices'=>$invoices]);
    }
    public function getPaid(){
        $invoices=$this->invoice::select('invoice_number','user','product','section','total','status')->where('status','1')->paginate(30);
        return view('invoices.invoices-paid',['invoices'=>$invoices]);
    }
    public function getNotPaid(){
        $invoices=$this->invoice::select('invoice_number','user','product','section','total','status')->where('status','0')->paginate(30);
        return view('invoices.invoices-notPaid',['invoices'=>$invoices]);
    }
    public function getPartiallyPaid(){
        $invoices=$this->invoice::select('invoice_number','user','product','section','total','status')->where('status','2')->paginate(30);
        return view('invoices.invoices-partiallyPaid',['invoices'=>$invoices]);
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $invoice=$this->invoice::where('invoice_number',$id)->firstOrFail();

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Invoice $invoice)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Invoice $invoice)
    {
        //
    }
}