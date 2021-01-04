@extends('layouts.master')
@section('css')
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
@endsection
@section('page-header')

@endsection
@section('title')
    {{ __('invoice.create invoice') }}
@endsection
@section('content')
    <!-- row -->
    <div class="row mt-2">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ __('invoice.create invoice') }}
                    </div>
                    <form action="{{ route('invoice.store') }}" method="POST" autocomplete="off">
                        @csrf
                        <div class="row row-xs formgroup-wrapper mt-4">
                            {{-- invoice number --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.invoice number') }}</label> <input
                                        class="form-control" placeholder="EX:1999" type="text" value=""
                                        name="invoiceNumber">
                                </div><!-- main-form-group -->
                            </div>
                            {{-- invoice date --}}
                            <div class="col-md-4 ">
                                <label class="form-label">{{ __('invoice.invoice date') }}</label>
                                <div class="row row-sm mg-b-20 ">
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div><input class="form-control" id="datetimepicker" name="invoiceDate" type="text"
                                            value="2018-12-20 21:05">
                                    </div>
                                </div>
                            </div>
                            {{-- invoice due date --}}
                            <div class="col-md-4 ">
                                <label class="form-label">{{ __('invoice.due date') }}</label>
                                <div class="row row-sm mg-b-20 ">
                                    <div class="input-group ">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div><input class="form-control fc-datepicker" id="invoiceDueDate"
                                            name="invoiceDueDate" placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                </div>
                            </div>
                            {{-- department --}}
                            <div class="col-lg-4 ">
                                <p class="mg-b-10">{{ __('invoice.Department') }}</p><select onchange="getProducts(this.value)" id="departments"
                                    class="form-control select2">
                                    <option label="Choose Department">
                                    </option>
                                    @foreach ($departments as $department)
                                        <option value="{{ $department->id }}">
                                            {{ $department->title }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            {{-- prodcuts --}}
                            <div class="col-lg-4 ">
                                <p class="mg-b-10">{{ __('invoice.product') }}</p><select id="prodcuts" disabled
                                    class="form-control select2">
                                </select>
                            </div>
                            {{-- money amount --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.paid amount') }}</label> <input id="paidAmount"
                                        class="form-control" type="text" value="0" name="paidAmount">
                                </div>
                            </div>
                            {{-- amount Commision--}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.commision amount') }}</label> <input
                                        class="form-control" type="text" value="0" name="commisionAmount"
                                        id="commisionAmount">
                                </div>
                            </div>
                            {{-- discount --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.deduction') }}</label> <input
                                        class="form-control" type="text" value="0" name="deductionAmount"
                                        id="deductionAmount">
                                </div>
                            </div>
                            {{-- vat rate --}}
                            <div class="col-md-4">
                                <label class="form-label">{{ __('invoice.vat rate') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div><input class="form-control" type="text" value="0" name="vatRate" id="vatRate">
                                </div>
                            </div>
                            {{-- vat value --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.vat value') }}</label> <input
                                        class="form-control" disabled type="text" value="0" name="vatValue" id="vatValue">
                                </div>
                            </div>
                            {{-- Total --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.total') }}</label> <input class="form-control "
                                        disabled type="text" value="0" name="totalAmount" id="totalAmount">
                                </div><!-- main-form-group -->
                            </div>
                            {{-- notes --}}
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.note') }}</label><textarea class="form-control"
                                        placeholder="Write your notes here ..." name="notes" id="notes" rows="4"></textarea>
                                </div><!-- main-form-group -->
                            </div>
                            {{-- Attachments --}}
                            <div class="col-md-6">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row row-sm">
                                            <div class="col-12">
                                                <div class="custom-file">
                                                    <input class="custom-file-input" id="attachments" name="attachments"
                                                        type="file" multiple> <label class="custom-file-label"
                                                        for="attachments">{{ __('invoice.attachments') }}</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            {{-- submit buttons --}}
                            <div class="row row-xs wd-xl-80p">
                                <div class="col-sm-6 col-md-3 mg-t-10 mg-md-t-0">
                                    <button class="btn btn-success btn-block"
                                        type="submit">{{ __('invoice.create') }}</button>
                                </div>
                                <div class="col-sm-6 col-md-3 mg-t-10 mg-sm-t-0">
                                    <button class="btn btn-secondary btn-block"
                                        type="reset">{{ __('invoice.cancel') }}</button>
                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <script>
        //this function is called when department is choosen
        function getProducts(e){
            $productsContainer=document.getElementById('prodcuts');
            $productsContainer.innerHTML='<option label="Choose product"></option>';
            fetch(`/invoice/get/products/${e}`)
            .then(response => response.json())
            .then(data => {
                if(data.length<=0){
                    if(!$productsContainer.hasAttribute("disabled")){
                        $productsContainer.setAttribute('disabled',"disabled");
                   }
                    alert("{{ __('invoice.There is no products in this department') }}");
                }else{
                   for(let product of data){
                       //loop over the response products and add them to options
                        $productsContainer.innerHTML+=`
                                    <option value="${product.id}">
                                        ${product.title}
                                    </option>
                        `;
                   }
                   if($productsContainer.hasAttribute("disabled")){
                        $productsContainer.removeAttribute('disabled');
                   }
                }
            });
        }
    </script>
@endsection
