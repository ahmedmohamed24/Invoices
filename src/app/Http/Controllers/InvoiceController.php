<?php

namespace App\Http\Controllers;

use App\Models\Department;
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
    private Department $department;
    public function __construct(Invoice $invoice,Department $department)
    {
        $this->invoice=$invoice;
        $this->department=$department;
    }
    public function index()
    {
        $invoices=$this->invoice::select('invoice_number','user','product','department','total','status')->paginate(30);
        return view('invoices.invoices',['invoices'=>$invoices]);
    }
    public function getPaid(){
        $invoices=$this->invoice::select('invoice_number','user','product','department','total','status')->where('status','1')->paginate(30);
        return view('invoices.invoices-paid',['invoices'=>$invoices]);
    }
    public function getNotPaid(){
        $invoices=$this->invoice::select('invoice_number','user','product','department','total','status')->where('status','0')->paginate(30);
        return view('invoices.invoices-notPaid',['invoices'=>$invoices]);
    }
    public function getPartiallyPaid(){
        $invoices=$this->invoice::select('invoice_number','user','product','department','total','status')->where('status','2')->paginate(30);
        return view('invoices.invoices-partiallyPaid',['invoices'=>$invoices]);
    }
    /**
     * Show the form for creating a new Invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $departments=$this->department::all();
        return view('invoices.create',['departments'=>$departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        dd($request);
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
    /**
     * retrieves the products based on the selected dapartment
     * @param int $departmentId
     * @return object
     */
    public function getDepartmentProducts($departmentId){
        $products=$this->department::findOrFail($departmentId);
        return $products->product;
    }
}
