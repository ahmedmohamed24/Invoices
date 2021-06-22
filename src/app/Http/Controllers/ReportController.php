<?php

namespace App\Http\Controllers;

use App\Http\Traits\CustomResponse;
use App\Models\Department;
use App\Models\Invoice;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    use CustomResponse;
    private Invoice $invoice;
    private Department $department;

    public function __construct()
    {
        $this->invoice = new Invoice();
        $this->department = new Department();
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

    public function searchRange(Request $request)
    {
        $request->validate([
            'status' => 'required',
            'status.*' => ['required', 'string', 'in:all,0,1,2,archive'],
            'rangeStart' => 'required|date',
            'rangeEnd' => 'required|date',
        ]);
        //search in all invoices
        $data = null;
        if (in_array('all', $request->status)) {
            $data = $this->invoice::whereBetween('invoice_date', [$request->rangeStart, $request->rangeEnd])->get();
        } else {
            if (in_array('archive', $request->status)) {
                if (1 === count($request->status)) {
                    //only archived choosed
                    $data = $this->invoice::where('deleted_at', '!=', null)
                        ->whereBetween('invoice_date', [$request->rangeStart, $request->rangeEnd])->get();
                } else {
                    $data = $this->invoice::where('deleted_at', '!=', null)
                        ->whereBetween('invoice_date', [$request->rangeStart, $request->rangeEnd])
                        ->where(function ($query) use ($request) {
                            $query->orWhere('status', $request->status[0] ?? null)
                                ->orWhere('status', $request->status[1] ?? null)
                                ->orWhere('status', $request->status[2] ?? null)
                                ->orWhere('status', $request->status[3] ?? null)
                                ->orWhere('status', $request->status[4] ?? null)
                            ;
                        })
                        ->get()
                    ;
                }
            } else {
                $data = $this->invoice::where('deleted_at', null)
                    ->whereBetween('invoice_date', [$request->rangeStart, $request->rangeEnd])
                    ->where(function ($query) use ($request) {
                        $query->where('status', $request->status[0] ?? null)
                            ->orWhere('status', $request->status[1] ?? null)
                            ->orWhere('status', $request->status[2] ?? null)
                            ->orWhere('status', $request->status[3] ?? null)
                            ->orWhere('status', $request->status[4] ?? null)
                        ;
                    })
                    ->get()
                ;
            }
        }
        if ($data) {
            return back()->with('invoices', $data);
        }
        //if no data found
        return back()->with('nullResult', true);
    }

    public function searchNumber(Request $request)
    {
        $request->validate([
            'invoice_number' => ['required', 'string', 'max:255'],
        ]);
        $invoice = $this->invoice::where('invoice_number', $request->invoice_number)->get();
        if (!$invoice->isEmpty()) {
            return back()->with('invoices', $invoice);
        }

        return back()->with('nullResult', true);
    }

    public function main()
    {
        $departments = $this->department::all();

        return view('reports.departments', ['departments' => $departments]);
    }

    public function searchDepartment(Request $request)
    {
        $request->validate([
            'department' => ['required', 'numeric', 'exists:departments,id'],
            'product' => ['required', 'numeric', 'exists:products,id'],
            'rangeStart' => ['required', 'date'],
            'rangeEnd' => 'required|date',
        ]);
        $invoices = $this->invoice::where('department', $request->department)
            ->where('product', $request->product)
            ->whereBetween('created_at', [$request->rangeStart, $request->rangeEnd])
            ->get()
        ;
        if (!$invoices->isEmpty()) {
            return back()->with('invoices', $invoices);
        }

        return back()->with('nullResult', true);
    }
}
