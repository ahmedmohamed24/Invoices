@extends('layouts.master')
@section('css')
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
    {{ __('report.reports') }}
@endsection
@section('content')
				<!-- row -->
				<div class="row bg-white my-3">
                    @if (session('nullResult')!==null)
                        <p class="alert alert-danger my-3">No data found</p>
                    @endif
                    <div class="panel w-100 panel-primary tabs-style-2">
                        <div class=" tab-menu-heading">
                            <div class="tabs-menu1">
                                <!-- Tabs -->
                                <ul class="nav panel-tabs main-nav-line">
                                    <li><a href="#tab1" class="nav-link active" data-toggle="tab">{{ __('report.status')}}</a></li>
                                    <li><a href="#tab2" class="nav-link" data-toggle="tab">{{ __('report.invoice number') }}</a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="panel-body tabs-menu-body main-content-body-right w-100 border">
                            <div class="tab-content">
                                <div class="tab-pane active" id="tab1">
                                    <form action="{{ route('report.search.range') }}" method="post" class="">
                                        @csrf
                                        <div class="form-group">
                                            <select class="form-control" multiple name='status[]'>
                                                <option value="all">{{ __('report.all') }}</option>
                                                <option value="1">{{ __('report.paid') }}</option>
                                                <option value="0">{{ __('report.not paid') }}</option>
                                                <option value="2">{{ __('report.partially paid') }}</option>
                                                <option value="archive">{{ __('report.archived') }}</option>
                                            </select>
                                        </div>
                                        @error('status')
                                           <p class="alert alert-danger my-2">{{ $message }}</p>
                                        @enderror
                                        {{-- range start --}}
                                        <div class="form-group">
                                            <label class="form-label">{{ __('report.start range') }}</label>
                                            <div class="row row-sm mg-b-20 ">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                        </div>
                                                    </div><input class="form-control fc-datepicker" value="{{ old('rangeStart') }}" id="datetimepicker2"name="rangeStart" placeholder="MM/DD/YYYY" type="text">
                                                </div>
                                            </div>
                                        </div>
                                        @error('rangeStart')
                                           <p class="alert alert-danger my-2">{{ $message }}</p>
                                        @enderror
                                        {{-- range end --}}
                                        <div class="form-group">
                                            <label class="form-label">{{ __('report.end range') }}</label>
                                            <div class="row row-sm mg-b-20 ">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">
                                                            <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                                        </div>
                                                    </div><input class="form-control fc-datepicker" id="datetimepicker22" name="rangeEnd" placeholder="MM/DD/YYYY" type="text" value="{{ old('rangeEnd') }}">
                                                </div>
                                            </div>
                                        </div>
                                        @error('rangeEnd')
                                           <p class="alert alert-danger my-2">{{ $message }}</p>
                                        @enderror
                                        <input class="btn btn-info" type="submit" value="{{ __('report.search') }}">
                                    </form>
                                </div>
                                <div class="tab-pane" id="tab2">
                                    <form action="{{ route('report.search.number') }}" method="post" class="">
                                        @csrf

                                        {{-- search invoices by number  --}}
                                        <div class="form-group">
                                            <label for="invoice_number">{{ __('report.invoice number') }}</label>
                                            <input type="text" name="invoice_number" id="invoice_number" class="form-control">
                                        </div>
                                        <input class="btn btn-info" type="submit" value="{{ __('report.search') }}">
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @if(session('invoices') !==null)
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
                                @foreach (session()->get('invoices') as $invoice)
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
                                        <a href="{{ route('invoice.show',$invoice->id) }}" class="btn btn-primary ml-2 text-light">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a class="btn btn-info ml-2 text-light"
                                            onclick="event.preventDefault();showUpdateModel('{{ route('invoice.getInvoiceInfo',$invoice->id) }}');"><i
                                                class="las la-pen"></i></a>
                                        <form action="{{ route('invoice.destroy') }}" method="POST">
                                            @csrf
                                            <input type="hidden" name="id" value="{{ $invoice->id }}">
                                            <button class="btn btn-danger" type="submit"><i class="las la-trash"></i></button>
                                        </form>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
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
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>


<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
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
