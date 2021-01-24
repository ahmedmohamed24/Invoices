@extends('layouts.master')
@section('css')
@endsection
@section('title')
    {{ __('main-sidebar.view notifications') }}
@endsection
@section('content')
                <!-- row -->
				<div class="row">
					<div class="col-12">
						<div class="card">
							<div class="card-body">
								<div class="d-flex justify-content-between">
									<h4 class="card-title">{{ __('main-sidebar.All notifications') }}</h4>
									<i class="mdi mdi-dots-vertical"></i>
								</div>
                                @foreach ($notifications as $notification)
                                    <a href="{{ $notification->data['link'] }}"  class="list @if ($notification->read_at)  text-muted  @endif d-flex align-items-center border-bottom py-3">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="header-icon-svgs" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
                                            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
                                        </svg>
                                        <div class="wrapper w-100 mr-3">
                                            <p class="mb-0">
                                            <b>{{ $notification->data['Description'] }}</p>
                                            <div class="d-sm-flex justify-content-between align-items-center">
                                                <small class="text-muted "><i class="mdi mdi-clock text-muted "></i>{{  \Carbon\Carbon::parse($notification->created_at)->diffForHumans()  }}</small>
                                            </div>
                                        </div>
                                    </a>
                                @endforeach
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
@endsection
