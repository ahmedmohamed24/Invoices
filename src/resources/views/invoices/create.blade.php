@extends('layouts.master')
@section('css')
<!--Internal   Notify -->
    <link href="{{URL::asset('assets/plugins/notify/css/notifIt.css')}}" rel="stylesheet"/>
    <!-- Internal Select2 css -->
    <link href="{{ URL::asset('assets/plugins/select2/css/select2.min.css') }}" rel="stylesheet">
    <!--Internal  Datetimepicker-slider css -->
    <link href="{{ URL::asset('assets/plugins/amazeui-datetimepicker/css/amazeui.datetimepicker.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/jquery-simple-datetimepicker/jquery.simple-dtpicker.css') }}"
        rel="stylesheet">
    <link href="{{ URL::asset('assets/plugins/pickerjs/picker.min.css') }}" rel="stylesheet">
    <!-- Internal Spectrum-colorpicker css -->
    <link href="{{ URL::asset('assets/plugins/spectrum-colorpicker/spectrum.css') }}" rel="stylesheet">
    <!---Internal Fileupload css-->
    <link href="{{URL::asset('assets/plugins/fileuploads/css/fileupload.css')}}" rel="stylesheet" type="text/css"/>

    <style>
        #notes{
            height: auto !important;
        }
    </style>
@endsection
@section('page-header')

@endsection
@section('title')
    {{ __('invoice.create invoice') }}
@endsection
@section('content')
@if ($errors->any())
<div class="alert alert-danger">
   @foreach ($errors->all() as $error)
        <p>{{ $error }}</p>
   @endforeach
</div>
@endif
    <!-- row -->
    <div class="row mt-2">
        <div class="col-lg-12 col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="main-content-label mg-b-5">
                        {{ __('invoice.create invoice') }}
                    </div>
                    <form action="{{ route('invoice.store') }}" enctype="multipart/form-data" method="POST" autocomplete="off">
                        @csrf
                        <div class="row row-xs formgroup-wrapper mt-4">
                            {{-- invoice number --}}
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.invoice number') }}</label> <input
                                        class="form-control" placeholder="EX:1999" type="text" value="{{ old('invoiceNumber') }}"
                                        name="invoiceNumber">
                                </div><!-- main-form-group -->
                            </div>
                            {{-- invoice date --}}
                            <div class="col-md-4 ">
                                <label class="form-label">{{ __('invoice.invoice date') }}</label>
                                <div class="row row-sm mg-b-20 ">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div><input class="form-control fc-datepicker" value="{{ old('invoiceDate') }}" id="datetimepicker2"name="invoiceDate" placeholder="MM/DD/YYYY" type="text">
                                    </div>
                                </div>
                            </div>
                            {{-- invoice due date --}}
                            <div class="col-md-4 ">
                                <label class="form-label">{{ __('invoice.due date') }}</label>
                                <div class="row row-sm mg-b-20 ">
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">
                                                <i class="typcn typcn-calendar-outline tx-24 lh--9 op-6"></i>
                                            </div>
                                        </div><input class="form-control fc-datepicker" id="datetimepicker22" name="invoiceDueDate" placeholder="MM/DD/YYYY" type="text" value="{{ old('invoiceDueDate') }}">
                                    </div>
                                </div>
                            </div>
                            {{-- department --}}
                            <div class="col-lg-4 ">
                                <p class="mg-b-10">{{ __('invoice.Department') }}</p><select name="department" onchange="getProducts(this.value)"onfocusout="getProducts(this.value)" id="departments"
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
                                <p class="mg-b-10">{{ __('invoice.product') }}</p><select name="product" id="prodcuts" disabled
                                    class="form-control select2">
                                </select>
                            </div>
                            {{-- paid amount --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="mg-b-10 form-label">{{ __('invoice.paid amount') }}</label> <input id="paidAmount"
                                        class="form-control" type="text" value="{{ old('paidAmount')??0 }}"  onchange="claculateCommisionAmount()" onfocusout="claculateCommisionAmount()" onchange="claculateCommisionAmount()" name="paidAmount">
                                </div>
                                <small class="alert alert-danger d-none" id="paidAmountError">{{ __('invoice.paid amount error') }}</small>
                            </div>
                            {{-- Commision percent--}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.commision percent') }}</label> <input
                                        class="form-control" type="text" onfocusout="claculateCommisionAmount()"onchange="claculateCommisionAmount()" onchange="claculateCommisionAmount()" value="{{ old('commisionPercent')??0 }}" name="commisionPercent"
                                        id="commisionPercent">
                                </div>
                                <small class="alert alert-danger d-none" id="comissionError">{{ __('invoice.commision percent error') }}</small>
                            </div>
                            {{-- commision Amount --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.commision amount') }}</label> <input
                                        class="form-control" type="text" value="{{ old('commisionAmount')??0 }}" name="commisionAmount" readonly
                                        id="commisionAmount">
                                </div>
                            </div>
                            {{-- deduction--}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.deduction') }}</label> <input
                                        class="form-control" type="text" value="{{ old('deductionAmount')??0 }}" onfocusout="changeDeductionAmount()" onchange="changeDeductionAmount()"name="deductionAmount"
                                        id="deductionAmount">
                                </div>
                                <small class="alert alert-danger d-none" id='deductionError'>{{ __('invoice.deduction amount error') }}</small>
                            </div>
                            {{-- vat percent--}}
                            <div class="col-lg-4 col-md-6">
                                <label class="form-label">{{ __('invoice.vat rate') }}</label>
                                <div class="input-group mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">%</span>
                                    </div><input onchange="calculateVatValue()"onfocusout="calculateVatValue()" class="form-control" type="text" value="{{ old('vatRate')??0 }}" name="vatRate" id="vatRate">
                                </div>
                                <small class="alert alert-danger d-none" id="vatRateError">{{ __('invoice.vat rate error') }}</small>
                            </div>
                            {{-- vat value --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.vat value') }}</label> <input
                                        class="form-control" readonly type="text" value="{{ old('vatValue')??0 }}" name="vatValue" id="vatValue">
                                </div>
                            </div>
                            {{-- Total --}}
                            <div class="col-lg-4 col-md-6">
                                <div class="form-group">
                                    <label class="form-label">{{ __('invoice.total') }}</label> <input class="form-control "
                                        readonly type="text" value="{{ old('totalAmount')??0 }}" name="totalAmount" id="totalAmount">
                                </div><!-- main-form-group -->
                            </div>
                            {{-- notes --}}
                            <div class="col-12">
                                <label class="form-label">{{ __('invoice.note') }}</label>
                                <div class="">
                                    <textarea class="form-control" placeholder="Write your notes here ..." name="notes" cols="auto" id="notes" rows="5" >{{ old('notes') }}</textarea>
                                </div>
                            </div>
                            {{-- Attachments --}}
                            <div class="col-12">
                                <label for="attachments">{{ __('invoice.attachments') }}</label>
                                <div class="col-12 ">
									<input type="file" class="dropify" data-height="200" id="attachments" name="attachments" multiple/>
								</div>
                            </div>
                            {{-- submit buttons --}}
                            <div class="d-flex  align-items-center col-md-6 mt-2">
                                <div class="ml-2">
                                    <button id="submitBtn" class="btn px-5 btn-success btn-block "
                                        type="submit" disabled>{{ __('invoice.create') }}</button>
                                </div>
                                <div class=" ">
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
    <!--Internal Fileuploads js-->
    <script src="{{URL::asset('assets/plugins/fileuploads/js/fileupload.js')}}"></script>
    <script src="{{URL::asset('assets/plugins/fileuploads/js/file-upload.js')}}"></script>

    <script>
        const productsContainer=document.getElementById('prodcuts');
        //error containers
        const vatRateError=document.getElementById('vatRateError');
        const paidAmountError=document.getElementById('paidAmountError');
        const comissionError=document.getElementById('comissionError');
        const deductionError=document.getElementById('deductionError');
        //elements to get their values
        const vatRate=document.getElementById('vatRate');
        const paidAmount=document.getElementById('paidAmount');
        const deductionAmount=document.getElementById('deductionAmount');
        const commisionPercent=document.getElementById('commisionPercent');
        //elements to calculate their values
        const commisionAmount=document.getElementById('commisionAmount');
        const vatValue=document.getElementById('vatValue');
        const totalAmount=document.getElementById('totalAmount');

        const submitBtn=document.getElementById('submitBtn');
        //this function is called when department is choosen
        function getProducts(e){
            productsContainer.innerHTML='<option label="Choose product"></option>';
            fetch(`/invoice/get/products/${e}`)
            .then(response => response.json())
            .then(data => {
                if(data.length<=0){
                    if(!productsContainer.hasAttribute("disabled")){
                        productsContainer.setAttribute('disabled',"disabled");
                   }
                    //alert("{{ __('invoice.There is no products in this department') }}");
                    not8()
                }else{
                   for(let product of data){
                       //loop over the response products and add them to options
                        productsContainer.innerHTML+=`
                                    <option value="${product.id}">
                                        ${product.title}
                                    </option>
                        `;
                   }
                   if(productsContainer.hasAttribute("disabled")){
                        productsContainer.removeAttribute('disabled');
                   }
                }
            });
        }

        function claculateCommisionAmount(){
            let paidAmountVal=parseFloat(paidAmount.value);
            let commisionPercentVal=parseFloat(commisionPercent.value);
            if(isNaN(paidAmountVal)){
                showErrorContainer(paidAmountError);
            }else if(isNaN(commisionPercentVal)){
                showErrorContainer(comissionError);
            }else{
                hideErrorcontainer(paidAmountError);
                hideErrorcontainer(comissionError);
                let val=((commisionPercentVal/100)*paidAmountVal);
                commisionAmount.value=((commisionPercentVal/100)*paidAmountVal);
                calculateTotalAmount()
            }
        }

        function calculateVatValue(){
            let vatPercent=parseFloat(vatRate.value);
            let paidAmountVal=parseFloat(paidAmount.value);
            if(isNaN(vatPercent)){
                showErrorContainer(vatRateError);
            }else if(isNaN(paidAmountVal)){
                showErrorContainer(paidAmountError);
            }else{
                hideErrorcontainer(vatRateError);
                hideErrorcontainer(paidAmountError);
                vatValue.value=(vatPercent/100*paidAmountVal)
                calculateTotalAmount()
            }
        }

        function changeDeductionAmount(){
            let deductionValue=parseFloat(deductionAmount.value);
            if(isNaN(deductionValue)){
               showErrorContainer(deductionError);
            }else{
                hideErrorcontainer(deductionError);
                deductionAmount.value=deductionValue;
                calculateTotalAmount();
            }
        }

        function calculateTotalAmount(){
            totalAmount.value=(parseFloat(vatValue.value)+parseFloat(commisionAmount.value)-parseFloat(deductionAmount.value));
            if(isNaN(totalAmount.value))
                submitBtn.setAttribute('disabled','disabled');
            else
                submitBtn.removeAttribute('disabled');
        }

        function showErrorContainer(container){
            if(container.classList.contains('d-none')){
                container.classList.remove('d-none')
            }
        }

        function hideErrorcontainer(container){
            if(!container.classList.contains('d-none')){
                container.classList.add('d-none')
            }
        }

        //sending a notification error message
        function not8() {
            notif({
                msg: "<b>{{ __('invoice.There is no products in this department') }}",
                type: "error",
                position: "center"
            });
        }
    </script>
<!--Internal  Notify js -->
<script src="{{URL::asset('assets/plugins/notify/js/notifIt.js')}}"></script>

@endsection
