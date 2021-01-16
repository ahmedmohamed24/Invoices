<?php

namespace App\Http\Controllers;

use App\Http\Traits\CustomResponse;
use App\Models\Invoice;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use App\Http\Traits\UploadImage;
use App\Models\Attachment;
use App\Models\InvoiceDetails;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    use UploadImage,CustomResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private Invoice $invoice;
    private Department $department;
    private InvoiceDetails $invoiceDetails;
    private Attachment $attachment;
    public function __construct(Invoice $invoice,Department $department, InvoiceDetails $invoiceDetails, Attachment $attachment)
    {
        $this->invoice=$invoice;
        $this->department=$department;
        $this->invoiceDetails=$invoiceDetails;
        $this->attachment=$attachment;
    }
    public function index()
    {
        $invoices=$this->invoice::with('user')->where('deleted_at',null)->paginate(30);
        return view('invoices.invoices',['invoices'=>$invoices]);
    }
    public function getPaid(){
        $invoices=$this->invoice::with('user')->where('status',1)->where('deleted_at',null)->paginate(30);
        return view('invoices.invoices',['invoices'=>$invoices]);
    }
    public function getArchived(){
        $invoices=$this->invoice::with('user')->where('deleted_at','!=',null)->paginate(30);
        return view('invoices.archive',['invoices'=>$invoices]);
    }
    public function getNotPaid(){
        $invoices=$this->invoice::with('user')->where('status',0)->where('deleted_at',null)->paginate(30);
        return view('invoices.invoices',['invoices'=>$invoices]);
    }
    public function getPartiallyPaid(){
        $invoices=$this->invoice::with('user')->where('status',2)->where('deleted_at',null)->paginate(30);
        return view('invoices.invoices',['invoices'=>$invoices]);
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
        //deduction, vat-rate, vat-value, total
        $request->validate([
            'invoiceNumber'=>'required|unique:invoices,invoice_number|string',
            'invoiceDate'=>'required|date',
            'invoiceDueDate'=>'required|date',
            'department'=>'required|exists:departments,id',
            'product'=> ['required',Rule::exists('products','id')->where(function($query)use($request){$query->where('department_id',$request->department);})],
            'commisionAmount'=>"required|numeric|min:0|max:999999",
            'deductionAmount'=>"required|numeric|min:0|max:$request->commisionAmount",
            'vatValue'=>"required|numeric|min:0|max:$request->commisionAmount",
            'totalAmount'=>"required|numeric",
            'notes'=>"string|nullable",
            'attachments'=>'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);
        $attachmentName=null;
        if($request->hasFile('attachments')){
            //upload these files
            $attachmentName=$this->uploadAttachment($request->attachments);
        }
        //store main data in invoices table and get the id to store the attachments and details
        $invoice=Invoice::create([
            'invoice_number'=> $request->invoiceNumber,
            'invoice_date'=> $request->invoiceDate,
            'due_date'=> $request->invoiceDueDate,
            'product'=> $request->product,
            'department'=> $request->department,
            'deduction'=> $request->deductionAmount,
            'commision_value'=> $request->commisionAmount,
            'vat_value'=> $request->vatValue,
            'total'=> $request->totalAmount,
            'status'=>0 ,
            'created_by'=> Auth::user()->id ,
            'deleted_at'=>null ,
            'created_at'=> now() ,
            'updated_at'=> null ,
        ]);
        $invoiceId=$invoice->id;
        if($attachmentName){
            Attachment::create([
                'invoice_id'=>$invoiceId,
                'attachment-path'=>$attachmentName,
                'created_at'=>now(),
                'updated_at'=>null
            ]);
        }
        return back()->with('msg','invoice added successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
       $invoice=$this->invoice::findOrFail($id);
        return view('invoices.showDetails',['invoice'=>$invoice]);
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
     *  update a specific fields in old data of invoices and push the old data to new invoice details table
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $validator=$request->validate([
            'id'=>"required|numeric",
            'invoiceDueDate'=>"required|date|after:today",
            'totalAmount'=>'required|numeric|min:0|max:999999',
            'status'=>["required","regex:/^(0|1|2)$/i"],
            'notes'=>'required|string',
            'attachments'=>'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);
        //if the data is valid, get the old data
        $oldInvoiceData=$this->invoice::where('deleted_at',null)->findOrFail($validator['id']);
        //change the format of status to insert it again
        switch($oldInvoiceData->status){
            case 'paid':
                $status=1;
            break;
            case 'not_paid':
                $status=0;
            break;
            default:
                $status=2;
        }
        //create new row in invoice-details table
        $detailsInfo=[
            'invoice_id'=>$validator['id'],
            'due_date'=>$oldInvoiceData->due_date,
            'total'=>$oldInvoiceData->total,
            'status'=> $status,
            'note'=>$validator['notes'],
            'created_by'=>Auth::user()->id,
            'created_at'=>now()
        ];
        //store the fetched old data to invoice-details table
        $this->invoiceDetails::create($detailsInfo);
        $this->invoice::where('deleted_at',null)->findOrFail($validator['id'])->update([
            'due_date'=>$validator['invoiceDueDate'],
            'total'=>$validator['totalAmount'],
            'status'=>$validator['status'],
            'update_at'=>now(),
        ]);
        //check if there is an attachment and store into attachments table
        if($request->hasFile('attachments')){
           $attachmentName=$this->uploadAttachment($request->attachments);
           $this->attachment::create(['invoice_id'=>$validator['id'],'attachment-path'=>$attachmentName,'created_at'=>now(),'updated_at'=>null,'created_by'=>Auth::id()]);
        }

        return back()->with('msg','invoice updated successfully');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $invoice)
    {
        $invoice->validate([
            'id'=>'required|numeric|exists:invoices,id'
        ]);
        $this->invoice::where('deleted_at',null)->findOrFail($invoice->id)->update([
            'deleted_at'=>now(),
        ]);
        return back()->with('msg','successfully deleted');
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
    /**
     * retrieves the info of an invoice to push them in modal for updating
     */
    public function getInfo(int $id){
        $invoiceInfo=$this->invoice::select('id','due_date','total','status')->where('deleted_at',null)->findOrFail($id);
        return $this->customResponse(200,'success',$invoiceInfo);
    }
    public function downloadAttachment(int $invoice_id,int $attach_id){
        $attach=$this->attachment::where('invoice_id',$invoice_id)->findOrFail($attach_id);
        // $file=Storage::getDriver('public_uploads')->getAdapter()->applyPathPrefix('uploads/invoices/'.$attach['attachment-path']);
        return Storage::drive('local')->download('uploads/invoices/'.$attach['attachment-path']);
        // return response()->download($file);
    }
    public function viewAttachment(int $invoice_id,int $attach_id){
        $attach=$this->attachment::where('invoice_id',$invoice_id)->findOrFail($attach_id);
        // $file=Storage::getDriver('public_uploads')->getAdapter()->applyPathPrefix('uploads/invoices/'.$attach['attachment-path']);
        $img=asset(Storage::drive('local')->url('uploads/invoices/'.$attach['attachment-path']));
        return "<img src='$img' />";
        // return response()->file($url);
    }
    public function deleteAttachment(int $invoice_id,int $attach_id){
        //may delete the file from storage also
        try{
            $this->attachment::where('invoice_id',$invoice_id)->findOrFail($attach_id)->delete();
            return back()->with('msg','deleted successfully');
        }catch(Exception $e){
            abort(404,$e->getMessage());
        }
    }

    public function deleteArchived(Request $invoice){
        $invoice->validate([
            'id'=>'required|numeric|exists:invoices,id'
        ]);
        $this->invoice::findOrFail($invoice->id)->delete();
        return back()->with('msg','successfully deleted');
    }

    public function restoreArchived(Request $invoice){
        $invoice->validate([
            'id'=>'required|numeric|exists:invoices,id'
        ]);
        $this->invoice::findOrFail($invoice->id)->update(['deleted_at'=>null]);
        return back()->with('msg','successfully restored');
    }
    public function addAttach(Request $attach){
        $attach->validate([
            'invoice'=>['required','numeric','exists:invoices,id'],
            'attach'=>['required','file','mimes:png,jpg,jpeg,pdf','max:2024']
        ]);

        $img=$this->uploadAttachment($attach->attach);
        $this->attachment::create([
            'invoice_id'=>$attach->invoice,
            'attachment-path'=>$img,
            'created_by'=>Auth::id()
        ]);
        return back()->with('msg','attachment added successfully');
    }
}
