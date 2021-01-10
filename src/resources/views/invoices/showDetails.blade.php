@extends('layouts.master')
@section('css')
@endsection
@section('title')
   {{ __('invoice.invoice details') }}
@endsection
@section('content')
				<!-- row -->
				<div class="row row-sm mt-2">
					<div class="col-md-12 col-xl-12">
						<div class=" main-content-body-invoice">
							<div class="card card-invoice">
								<div class="card-body">
                                    {{-- main details --}}
									<div class="invoice-header">
										<h1 class="invoice-title">{{ __('invoice.invoice') }}</h1>
									</div>
									<div class="row mg-t-20">
										<div class="col-md">
										    <h3 class="invoice-title mb-2">{{ __('invoice.invoice details') }}</h3>
											<p class="invoice-info-row"><span class="text-primary">{{ __('invoice.invoice number') }}</span><span>{{ $invoice->invoice_number}} </span></p>
											<p class="invoice-info-row"><span class="text-primary">{{ __('invoice.created_by') }}</span><span>{{ $invoice->user->name }} </span></p>
											<p class="invoice-info-row text-secondary"><span class="text-primary">{{ __('invoice.created_at') }}</span><span>{{ $invoice->created_at}} </span></p>
											<p class="invoice-info-row text-secondary" ><span class="text-primary">{{ __('invoice.updated_at') }}</span><span>@if ($invoice->updated_at)
                                                {{ $invoice->updated_at }}
                                            @else
                                                {{ __('invoice.not updated') }}
                                            @endif </span></p>
											<p class="invoice-info-row text-secondary"><span class="text-primary">{{ __('invoice.due date') }}</span><span>{{ $invoice->due_date }} </span></p>
											<p class="invoice-info-row"><span class="text-primary">{{ __('invoice.deduction') }}</span><span>{{ $invoice->deduction }} </span></p>
											<p class="invoice-info-row"><span class="text-primary">{{ __('invoice.commision amount') }}</span><span>{{ $invoice->commision_value }} </span></p>
											<p class="invoice-info-row"><span class="text-primary">{{ __('invoice.vat value') }}</span><span>{{ $invoice->vat_value}} </span></p>
                                            @switch($invoice->status)
                                                @case('paid')
                                                    <p class="invoice-info-row"><span class="text-primary">{{ __('invoice.status') }}</span><span class="label text-success ">{{ __('invoice.paid') }}</span></p>
                                                    @break
                                                @case('not_paid')
                                                    <p class="invoice-info-row"><span class="text-primary">{{ __('invoice.status') }}</span><span class="label text-danger">{{ __('invoice.not paid') }}</span></p>
                                                    @break
                                                @default
                                                    <p class="invoice-info-row"><span class="text-primary">{{ __('invoice.status') }}</span><span class="label text-warning">{{ __('invoice.partially paid') }}</span></p>
                                            @endswitch
                                            <p class="invoice-info-row"><span class="text-primary">{{ __('invoice.total') }}</span><span class="text-primary h2">{{ $invoice->total}}$ </span></p>
										</div>
                                    </div>
                                    {{-- view mor details --}}
									<h3 class="invoice-title mb-2">{{ __('invoice.more details') }}</h3>
									<div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="">#</th>
													<th class="">{{ __('invoice.due date') }}</th>
													<th class="">{{ __('invoice.total') }}</th>
                                                    <th class="">{{ __('invoice.status') }}</th>
                                                    <th class="">{{ __('invoice.note') }}</th>
                                                    <th class="">{{ __('invoice.created_by') }}</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($invoice->details as $detail)
                                                    <tr>
                                                        <td>{{ $loop->count }}</td>
                                                        <td class="tx-right text-secondary">{{ $detail->due_date}}</td>
                                                        <td class="tx-right text-info">{{ $detail->total}}</td>
                                                        @switch($detail->status)
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
                                                        <td class="tx-right">{{ $detail->note}}</td>
                                                        <td class="tx-right">{{ $detail->user->name}}</td>
                                                    </tr>
                                                @endforeach
											</tbody>
										</table>
									</div>
                                    <hr class="mg-b-40">
                                    {{-- attachments --}}
                                    <h3 class="invoice-title">{{ __('invoice.attachments') }}</h3>
                                    <div class="table-responsive mg-t-40">
										<table class="table table-invoice border text-md-nowrap mb-0">
											<thead>
												<tr>
													<th class="">#</th>
													<th class="wd-40p">{{ __('invoice.attachment') }}</th>
													<th class="">{{ __('invoice.created_at') }}</th>
													<th class="">{{ __('invoice.operations') }}</th>
												</tr>
											</thead>
											<tbody>
                                                @foreach ($invoice->attachments as $attachment)
                                                    <img src="{{asset($attachment['attachment-path'])}}" alt="">
                                                    <tr>
                                                        <td>{{ $loop->count }}</td>
                                                        <td class="wd-40p"><img class='img-fluid' src="{{ asset($attachment['attachment-path']) }}" alt=""></td>
                                                        <td class="">{{ $attachment->created_at}}</td>
                                                        <td class="">
                                                            <a class="btn btn-purple mt-1" href="">
                                                                <i class="fas fa-eye ml-1"></i>
                                                            </a>
                                                            <a href="{{ route('attach.download',['invoice_id'=>$attachment['invoice_id'],'attach_id'=>$attachment['id']]) }}" class="btn btn-info mt-1">
                                                              <i class="fas fa-download"></i>
                                                            </a>
                                                            <a href="#" class="btn btn-danger mt-1">
                                                                <i class="las la-trash"></i>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endforeach
											</tbody>
										</table>
									</div>

								</div>
							</div>
						</div>
					</div><!-- COL-END -->
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!--Internal  Chart.bundle js -->
<script src="{{URL::asset('assets/plugins/chart.js/Chart.bundle.min.js')}}"></script>
@endsection
