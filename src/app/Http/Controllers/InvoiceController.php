<?php

namespace App\Http\Controllers;

use Exception;
use App\Models\User;
use App\Models\Invoice;
use App\Models\Attachment;
use App\Models\Department;
use Illuminate\Http\Request;
use App\Events\InvoiceCreated;
use App\Models\InvoiceDetails;
use App\Exports\InvociesExport;
use Illuminate\Validation\Rule;
use App\Http\Traits\UploadImage;
use Illuminate\Support\Facades\DB;
use App\Http\Traits\CustomResponse;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    use UploadImage, CustomResponse;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private Invoice $invoice;
    private Department $department;
    private InvoiceDetails $invoiceDetails;
    private Attachment $attachment;
    private User $user;
    private Auth $auth;
    public function __construct()
    {
        $this->invoice = new Invoice;
        $this->user = new User;
        $this->department = new Department;
        $this->invoiceDetails = new InvoiceDetails;
        $this->attachment = new Attachment;
        $this->auth = new Auth;
    }
    protected function canShowInvoice()
    {
        if (!Auth::user()->hasPermissionTo('see invoices'))
            abort(404);
    }
    protected function canCreateInvoice()
    {
        if (!Auth::user()->hasPermissionTo('add invoice'))
            abort(404);
    }
    protected function canArchiveInvoice()
    {
        if (!Auth::user()->hasPermissionTo('archive invoices'))
            abort(404);
    }
    protected function canDeleteInvoice()
    {
        if (!Auth::user()->hasPermissionTo('delete inooice'))
            abort(404);
    }
    protected function canRestoreInvoice()
    {
        if (!Auth::user()->hasPermissionTo('restore invoices'))
            abort(404);
    }
    protected function canUpdateInvoice()
    {
        if (!Auth::user()->hasPermissionTo('edit invoices'))
            abort(404);
    }
    public function index()
    {
        $this->canShowInvoice();
        $invoices = $this->invoice::with('user')->where('deleted_at', null)->paginate(30);
        return view('invoices.invoices', ['invoices' => $invoices]);
    }
    public function getPaid()
    {
        $this->canShowInvoice();
        $invoices = $this->invoice::with('user')->where('status', 1)->where('deleted_at', null)->paginate(30);
        return view('invoices.invoices', ['invoices' => $invoices]);
    }
    public function getArchived()
    {
        $this->canShowInvoice();
        $invoices = $this->invoice::with('user')->where('deleted_at', '!=', null)->paginate(30);
        return view('invoices.archive', ['invoices' => $invoices]);
    }
    public function getNotPaid()
    {
        $this->canShowInvoice();
        $invoices = $this->invoice::with('user')->where('status', 0)->where('deleted_at', null)->paginate(30);
        return view('invoices.invoices', ['invoices' => $invoices]);
    }
    public function getPartiallyPaid()
    {
        $this->canShowInvoice();
        $invoices = $this->invoice::with('user')->where('status', 2)->where('deleted_at', null)->paginate(30);
        return view('invoices.invoices', ['invoices' => $invoices]);
    }
    /**
     * Show the form for creating a new Invoice.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $this->canCreateInvoice();
        $departments = $this->department::all();
        return view('invoices.create', ['departments' => $departments]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->canCreateInvoice();
        //deduction, vat-rate, vat-value, total
        $request->validate([
            'invoiceNumber' => 'required|unique:invoices,invoice_number|string',
            'invoiceDate' => 'required|date',
            'invoiceDueDate' => 'required|date',
            'department' => 'required|exists:departments,id',
            'product' => ['required', Rule::exists('products', 'id')->where(function ($query) use ($request) {
                $query->where('department_id', $request->department);
            })],
            'commisionAmount' => "required|numeric|min:0|max:999999",
            'deductionAmount' => "required|numeric|min:0|max:$request->commisionAmount",
            'vatValue' => "required|numeric|min:0|max:$request->commisionAmount",
            'totalAmount' => "required|numeric",
            'notes' => "string|nullable",
            'attachments' => 'nullable|file|mimes:png,jpg,jpeg,pdf|max:2048',
        ]);
        try {
            DB::beginTransaction(); //to make sure all data is added or all was canceled
            $attachmentName = null;
            if ($request->hasFile('attachments')) {
                //upload this file
                $attachmentName = $this->uploadAttachment($request->attachments);
            }
            //store main data in invoices table and get the id to store the attachments and details
            $invoice = Invoice::create([
                'invoice_number' => $request->invoiceNumber,
                'invoice_date' => $request->invoiceDate,
                'due_date' => $request->invoiceDueDate,
                'product' => $request->product,
                'department' => $request->department,
                'deduction' => $request->deductionAmount,
                'commision_value' => $request->commisionAmount,
                'vat_value' => $request->vatValue,
                'total' => $request->totalAmount,
                'status' => 0,
                'created_by' => Auth::user()->id,
                'deleted_at' => null,
                'created_at' => now(),
                'updated_at' => null,
            ]);
            $invoiceId = $invoice->id;
            if ($attachmentName) {
                Attachment::create([
                    'invoice_id' => $invoiceId,
                    'attachment-path' => $attachmentName,
                    'created_at' => now(),
                    'created_by' => Auth::id(),
                    'updated_at' => null
                ]);
            }
            //fire the event ro send notfications to admins and send email to the owner
            event(new InvoiceCreated($invoice));

            DB::commit();
            return back()->with('msg', 'invoice added successfully');
        } catch (Exception $e) {
            //add it to log file with error message
            DB::rollback();
            // return back()->with('msg','something went wrong please contact the adminstrator');
            return back()->withErrors($e->getMessage()); //only for debugging
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $this->canShowInvoice();
        $invoice = $this->invoice::findOrFail($id);
        return view('invoices.showDetails', ['invoice' => $invoice]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function edit(Invoice $invoice)
    {
        return view('404');
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
        $this->canUpdateInvoice();
        $validator = $request->validate([
            'id' => "required|numeric",
            'invoiceDueDate' => "required|date|after:today",
            'totalAmount' => 'required|numeric|min:0|max:999999',
            'status' => ["required", "regex:/^(0|1|2)$/i"],
            'notes' => 'required|string',
            'attachments' => 'nullable|file|mimes:pdf,jpg,jpeg,png'
        ]);
        //if the data is valid, get the old data
        $oldInvoiceData = $this->invoice::where('deleted_at', null)->findOrFail($validator['id']);
        try {
            DB::beginTransaction();

            //change the format of status to insert it again
            switch ($oldInvoiceData->status) {
                case 'paid':
                    $status = 1;
                    break;
                case 'not_paid':
                    $status = 0;
                    break;
                default:
                    $status = 2;
            }
            //create new row in invoice-details table
            $detailsInfo = [
                'invoice_id' => $validator['id'],
                'due_date' => $oldInvoiceData->due_date,
                'total' => $oldInvoiceData->total,
                'status' => $status,
                'note' => $validator['notes'],
                'created_by' => Auth::user()->id,
                'created_at' => now()
            ];
            //store the fetched old data to invoice-details table
            $this->invoiceDetails::create($detailsInfo);
            $this->invoice::where('deleted_at', null)->findOrFail($validator['id'])->update([
                'due_date' => $validator['invoiceDueDate'],
                'total' => $validator['totalAmount'],
                'status' => $validator['status'],
                'update_at' => now(),
            ]);
            //check if there is an attachment and store into attachments table
            if ($request->hasFile('attachments')) {
                $attachmentName = $this->uploadAttachment($request->attachments);
                $this->attachment::create(['invoice_id' => $validator['id'], 'attachment-path' => $attachmentName, 'created_at' => now(), 'updated_at' => null, 'created_by' => Auth::id()]);
            }
            DB::commit();
            return back()->with('msg', 'invoice updated successfully');
        } catch (Exception $e) {
            DB::rollback();
            return back()->withErrors($e->getMessage()); //show these error for debugging only
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Invoice  $invoice
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $invoice)
    {
        $this->canArchiveInvoice();
        $invoice->validate([
            'id' => 'required|numeric|exists:invoices,id'
        ]);
        $this->invoice::where('deleted_at', null)->findOrFail($invoice->id)->update([
            'deleted_at' => now(),
        ]);
        return back()->with('msg', 'successfully deleted');
    }
    /**
     * retrieves the products based on the selected dapartment
     * @param int $departmentId
     * @return object
     */
    public function getDepartmentProducts($departmentId)
    {
        $this->canCreateInvoice();
        $products = $this->department::findOrFail($departmentId);
        return $products->product;
    }
    /**
     * retrieves the info of an invoice to push them in modal for updating
     */
    public function getInfo(int $id)
    {
        $this->canUpdateInvoice();
        $invoiceInfo = $this->invoice::select('id', 'due_date', 'total', 'status')->where('deleted_at', null)->findOrFail($id);
        return $this->customResponse(200, 'success', $invoiceInfo);
    }
    public function downloadAttachment(int $invoice_id, int $attach_id)
    {
        $this->canShowInvoice();
        $attach = $this->attachment::where('invoice_id', $invoice_id)->findOrFail($attach_id);
        return Storage::drive('local')->download('uploads/invoices/' . $attach['attachment-path']);
    }
    public function viewAttachment(int $invoice_id, int $attach_id)
    {
        $this->canShowInvoice();
        $attach = $this->attachment::where('invoice_id', $invoice_id)->findOrFail($attach_id);
        $img = asset(Storage::drive('local')->url('uploads/invoices/' . $attach['attachment-path']));
        return "<img style='max-width:100%;' height='auto' src='$img' />";
    }
    public function deleteAttachment(int $invoice_id, int $attach_id)
    {
        $this->canDeleteInvoice();
        //may delete the file from storage also
        try {
            $this->attachment::where('invoice_id', $invoice_id)->findOrFail($attach_id)->delete();
            return back()->with('msg', 'deleted successfully');
        } catch (Exception $e) {
            return back()->withErrors($e->getMessage());
            // return view('404');
        }
    }

    public function deleteArchived(Request $invoice)
    {
        $this->canDeleteInvoice();
        $invoice->validate([
            'id' => 'required|numeric|exists:invoices,id'
        ]);
        $this->invoice::findOrFail($invoice->id)->delete();
        return back()->with('msg', 'successfully deleted');
    }

    public function restoreArchived(Request $invoice)
    {
        $this->canRestoreInvoice();
        $invoice->validate([
            'id' => 'required|numeric|exists:invoices,id'
        ]);
        $this->invoice::findOrFail($invoice->id)->update(['deleted_at' => null]);
        return back()->with('msg', 'successfully restored');
    }
    public function addAttach(Request $attach)
    {
        $this->canCreateInvoice();
        $attach->validate([
            'invoice' => ['required', 'numeric', 'exists:invoices,id'],
            'attach' => ['required', 'file', 'mimes:png,jpg,jpeg,pdf', 'max:2024']
        ]);

        $img = $this->uploadAttachment($attach->attach);
        $this->attachment::create([
            'invoice_id' => $attach->invoice,
            'attachment-path' => $img,
            'created_by' => $this->auth::id()
        ]);
        return back()->with('msg', 'attachment added successfully');
    }
    public function exportInvoices()
    {
        $this->canShowInvoice();
        return Excel::download(new InvociesExport, "invoices-" . now() . "-.xlsx");
    }
    public function markAsRead($id)
    {
        $notification = $this->auth::user()->notifications->where('id', $id)->first();
        $notification->markAsRead();
        return  redirect($notification->data['link']);
    }
    public function markAllAsRead()
    {
        if ($this->auth::user()->unreadNotifications->count()) {
            $this->auth::user()->unreadNotifications->markAsRead();
        }
        return $this->customResponse(200, 'success');
    }
    public function showAllNotifications()
    {
        $notifications = $this->auth::user()->notifications;
        return view('notificaitons.show', ['notifications' => $notifications]);
    }
}
