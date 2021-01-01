@extends('layouts.master')
@section('title')
{{ __('invoice.all invoices') }}
@endsection
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
<div class="row my-3">
	<div class="col-sm-6 col-md-3">
        <button class="btn btn-primary-gradient btn-block">New Invoice</button>
        <div class="card custom-card">
			<div class="card-body">
				<div>
	    			<h6 class="card-title">Basic Modal</h6>
				</div>
				<a class="btn ripple btn-primary" data-target="#modaldemo1" data-toggle="modal" href="">View Demo</a>
			</div>
		</div>
	</div>
	<div class="col-sm-6 col-md-3 ">
		<button class="btn btn-warning-gradient btn-block">Archive</button>
	</div>
	<div class="col-sm-6 col-md-3 ">
		<button class="btn btn-danger-gradient btn-block">Delete</button>
	</div>
</div>

@endsection
@section('content')
				<!-- row opened -->
				<div class="row row-sm my-3">
					<div class="col-xl-12">
						<div class="card mg-b-20">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('invoice.all invoices') }}</h4>
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
												<th class="border-bottom-0">{{ __('invoice.section') }}</th>
												<th class="border-bottom-0">{{ __('invoice.total') }}</th>
												<th class="border-bottom-0">{{ __('invoice.status') }}</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($invoices as $invoice)
                                             <tr>
												<td><a href="{{ route('invoice.show',$invoice->invoice_number) }}">{{ $invoice->invoice_number }}</a></td>
												<td>{{ $invoice->user}}</td>
												<td>{{ $invoice->product }}</td>
												<td>{{ $invoice->section }}</td>
                                                <td>{{ $invoice->total }}</td>
                                                @switch($invoice->status)
                                                    @case('paid')
                                                        <td class="text-center">
                                                            <span class="label text-success d-flex"><div class="dot-label bg-success ml-1"></div>Paid</span>
                                                        </td>
                                                        @break
                                                    @case('not_paid')
                                                        <td class="text-center">
                                                            <span class="label text-danger d-flex"><div class="dot-label bg-danger ml-1"></div> Not Paid</span>
                                                        </td>
                                                        @break
                                                    @case('partially_paid')
                                                        <td class="text-center">
													        <span class="label text-muted d-flex"><div class="dot-label bg-gray-300 ml-1"></div>Partially Paid</span>
												        </td>
                                                        @break
                                                    @default
                                                        <td class="text-center">
                                                            <span class="label text-danger d-flex"><div class="dot-label bg-danger ml-1"></div> Error</span>
                                                        </td>
                                                @endswitch
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
@endsection
