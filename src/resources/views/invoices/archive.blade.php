@extends('layouts.master')
@section('title')
{{ __('invoice.archived') }}
@endsection
@section('css')
{{-- date time picker --}}
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
<!-- Internal Data table css -->
    <link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
    <link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
    <link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
    <style>
        #invoiceUpdateNotes{
            height: auto !important;
        }
    </style>
@endsection
@section('content')
                @if ($errors->any())
                    <div class="alert alert-danger">
                        @foreach ($errors->all() as $error)
                            <p class="my-1">{{ $error }}</p>
                        @endforeach
                    </div>
                @endif
                @if (session('msg')!==null)
                    <div class="alert alert-success">
                        {{ session()->get('msg') }}
                    </div>
                @endif
 				<!-- row opened -->
				<div class="row row-sm my-3">
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('invoice.archived') }}</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table id="example" class="table key-buttons text-md-nowrap">
										<thead>
											<tr>
                                                <th class="border-bottom-0">{{ __('invoice.invoice number') }}</th>
												<th class="border-bottom-0">{{ __('invoice.user') }}</th>
												<th class="border-bottom-0">{{ __('invoice.product') }}</th>
												<th class="border-bottom-0">{{ __('invoice.Department') }}</th>
												<th class="border-bottom-0">{{ __('invoice.total') }}</th>
												<th class="border-bottom-0">{{ __('invoice.status') }}</th>
                                                <th class="border-bottom-0">{{ __('product.operations') }}</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($invoices as $invoice)
                                             <tr>
												<td>{{ $invoice->invoice_number }}</td>
                                                <td>{{ $invoice->user->name}}</td>
												<td><a href="{{ route('product.show',$invoice->getProduct->id) }}">{{ $invoice->getProduct->title}}</a></td>
												<td><a href="{{ route('department.show',$invoice->getDepartment->id) }}">{{  $invoice->getDepartment->title}}</a></td>
                                                <td>{{ $invoice->total }}</td>
                                                @switch($invoice->status)
                                                    @case('paid')
                                                        <td class="text-center">
                                                            <span class="label text-success d-flex"><div class="dot-label bg-success ml-1"></div>{{ __('invoice.paid') }}</span>
                                                        </td>
                                                        @break
                                                    @case('not_paid')
                                                        <td class="text-center">
                                                            <span class="label text-danger d-flex"><div class="dot-label bg-danger ml-1"></div>{{ __('invoice.not paid') }}</span>
                                                        </td>
                                                        @break
                                                    @default
                                                        <td class="text-center">
													        <span class="label text-muted d-flex"><div class="dot-label bg-gray-300 ml-1"></div>{{ __('invoice.partially paid') }}</span>
                                                        </td>
                                                @endswitch
                                                <td class="d-flex">
                                                    @can('restore invoices')
                                                        <form action="{{ route('restore.archived') }}" class="ml-2" method="POST">
                                                            @csrf
                                                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                                                            <button class="btn btn-warning" title="restore" type="submit"><i class="mdi mdi-refresh"></i></button>
                                                        </form>
                                                    @endcan
                                                    @can('delete invoice')
                                                        <form action="{{ route('delete.archived') }}" method="POST">
                                                            @csrf
                                                            @method('delete')
                                                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                                                            <button class="btn btn-danger" type="submit"><i class="las la-trash"></i></button>
                                                        </form>
                                                    @endcan
                                                </td>
											</tr>
                                            @endforeach
										</tbody>
									</table>
								</div>
							</div>
						</div>
					</div>
				</div>
				<!-- /row -->
			</div>
			<!-- Container closed -->
        </div>
        <!-- main-content closed -->

        <!-- update and invoice section -->
        <div class="hidden">
            <a class="" id="showUpdateModal" data-effect="effect-scale" data-toggle="modal" href="#updateInvoiceModal">Scale</a>
        </div>
		<div class="modal" id="updateInvoiceModal">
			<div class="modal-dialog modal-lg" role="document">
				<div class="modal-content modal-content-demo">
                <form action="{{ route('invoice.update') }}" enctype="multipart/form-data" method="POST" autocomplete="off">
					<div class="modal-header">
						<h6 class="modal-title">{{ __('invoice.update') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                            @csrf
                            <input type="hidden" name="id" id="invoiceUpdateId" value="">
                            <div class="row row-xs formgroup-wrapper mt-4">
                                {{-- invoice due date --}}
                                <div class="col-md-4 col-md-6">
                                    <label class="form-label">{{ __('invoice.due date') }}</label>
                                    <div class="row row-sm mg-b-20 ">
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">
                                                    <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                </div>
                                            </div><input class="form-control fc-datepicker" id="datetimepicker2" name="invoiceDueDate" placeholder="MM/DD/YYYY" type="text" value="">
                                        </div>
                                    </div>
                                </div>
                                {{-- Total --}}
                                <div class=" col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">{{ __('invoice.total') }}</label> <input class="form-control "
                                            type="text" value="" name="totalAmount" id="invoiceUpdateTotalAmount">
                                    </div>
                                </div>
                                {{-- Status --}}
                                <div class="col-lg-4 col-md-12">
                                    <p class="">{{ __('invoice.status') }}</p><select name="status" id="invoiceUpdateStatus"
                                        class="form-control ">
                                        <option id="paidOption" value="1">{{ __('invoice.paid') }}</option>
                                        <option id="notPaidOption" value="0">{{ __('invoice.not paid') }}</option>
                                        <option id="partiallyPaidOption" value="2">{{ __('invoice.partially paid') }}</option>
                                    </select>
                                </div>
                                {{-- notes --}}
                                <div class="col-12">
                                    <label class="form-label">{{ __('invoice.note') }}</label>
                                    <div class="">
                                        <textarea class="form-control" placeholder="Write your notes here ..." name="notes" cols="auto" id="invoiceUpdateNotes" rows="5" ></textarea>
                                    </div>
                                </div>
                                {{-- Attachments --}}
                                <div class="col-12 pt-2">
                                    <label for="attachments">{{ __('invoice.attachments') }}</label>
                                    <div class="col-12 ">
										<input class="custom-file-input" id="customFile" type="file"name="attachments"> <label class="custom-file-label" for="customFile">Choose file</label>
                                    </div>
                                </div>
                            </div>
					</div>
					<div class="modal-footer">
                        {{-- submit buttons --}}
						<button class="btn ripple btn-primary" type="submit">{{ __('invoice.update') }}</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="reset">{{ __('invoice.cancel') }}</button>
					</div>
                </form>
				</div>
			</div>
		</div>
		<!--End Modal -->

@endsection
@section('js')
<!-- Internal Data tables -->
@if (LaravelLocalization::getCurrentLocale()=="ar")
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables-rtl.js')}}"></script>
@else
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
@endif
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>

    <script>
        function showUpdateModel(routeOfInvoiceDetails){
            fetch(routeOfInvoiceDetails)
            .then(response => response.json())
            .then(data => {
                //declare form inputs
                const idInput=document.getElementById('invoiceUpdateId');
                const dueDateInput=document.getElementById('datetimepicker2');
                const totalInput=document.getElementById('invoiceUpdateTotalAmount');
                const statusInput=document.getElementById('invoiceUpdateStatus');
                const notesInput=document.getElementById('invoiceUpdateNotes');
                const paidStatusOption=document.getElementById('paidOption');
                const notPaidStatusOption=document.getElementById('notPaidOption');
                const partiallyPaidStatusOption=document.getElementById('partiallyPaidOption');
                //set the fetched data to their inputs
                idInput.value=data.data.id;
                dueDateInput.value=data.data.due_date;
                totalInput.value=data.data.total;
                //make status option selected to the previous state
                switch(data.data.status){
                    case 'paid':
                        paidStatusOption.setAttribute('selected','selected');
                        notPaidStatusOption.removeAttribute('selected');
                        partiallyPaidStatusOption.removeAttribute('selected');
                    break;
                    case 'not_paid':
                        paidStatusOption.removeAttribute('selected');
                        notPaidStatusOption.setAttribute('selected','selected');
                        partiallyPaidStatusOption.removeAttribute('selected');
                    break;
                    default:
                        paidStatusOption.removeAttribute('selected');
                        notPaidStatusOption.removeAttribute('selected');
                        partiallyPaidStatusOption.setAttribute('selected','selected');
                }


                //after getting data display the update modal
                document.getElementById('showUpdateModal').click();
            })
            .catch(error => {
                console.error('There has been a problem with your fetch operation:', error);
            });


        }
    </script>
    <!--Internal  Datepicker js -->
    <script src="{{ URL::asset('assets/plugins/jquery-ui/ui/widgets/datepicker.js') }}"></script>
    <!--Internal  jquery.maskedinput js -->
    <script src="{{ URL::asset('assets/plugins/jquery.maskedinput/jquery.maskedinput.js') }}"></script>
    <!--Internal  spectrum-colorpicker js -->
    <script src="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.js') }}"></script>
    <!-- Internal Select2.min js -->
    <script src="{{ URL::asset('assets/plugins/select2/js/select2.min.js') }}"></script>
    <!--Internal Ion.rangeSlider.min js -->
    <script src="{{ URL::asset('assets/plugins/ion-rangeslider/js/ion.rangeSlider.min.js') }}"></script>
    <!--Internal  jquery-simple-datetimepicker js -->
    <script src="{{ URL::asset('assets/plugins/amazeui-datetimepicker/js/amazeui.datetimepicker.min.js') }}"></script>
    <!-- Ionicons js -->
    <script src="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.js') }}"></script>
    <!--Internal  pickerjs js -->
    <script src="{{ URL::asset('assets/plugins/pickerjs/picker.min.js') }}"></script>
    <!-- Internal form-elements js -->
    <script src="{{ URL::asset('assets/js/form-elements.js') }}"></script>

@endsection
