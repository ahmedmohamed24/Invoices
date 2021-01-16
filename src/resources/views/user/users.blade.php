@extends('layouts.master')
@section('title')

@endsection
@section('css')
@endsection
@section('content')
				<!-- row -->
				<div class="row mt-3">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('user.users list') }}</h4>
									<i class="mdi mdi-dots-horizontal text-gray"></i>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover mb-0 text-md-nowrap">
										<thead>
											<tr>
												<th>#</th>
												<th>{{ __('user.name') }}</th>
												<th>{{ __('user.email') }}</th>
												<th>{{ __('user.status') }}</th>
												<th>{{ __('user.permissios') }}</th>
												<th>{{ __('user.role') }}</th>
												<th>{{ __('user.operations') }}</th>
											</tr>
										</thead>
										<tbody>
                                            @foreach ($users as $user)
                                            <tr>
												<th scope="row">{{ $loop->index }}</th>
												<td>{{ $user->name}}</td>
												<td>{{ $user->email}}</td>
                                                @switch($user->status)
                                                    @case('active')
                                                        <td class="text-center">
                                                            <span class="label text-success d-flex"><div class="dot-label bg-success ml-1"></div>{{$user->status}}</span>
                                                        </td>
                                                        @break
                                                    @default
                                                        <td class="text-center">
													        <span class="label text-muted d-flex"><div class="dot-label bg-gray-300 ml-1"></div>{{$user->status}}</span>
                                                        </td>
                                                @endswitch
                                                <td>{{  $user->getRoleNames()[0]}}</td>
                                                <td>
                                                    @if(count($user->permissions) === 0)
                                                        <span class="text-center text-secondary">{{ __('user.no permissions') }}</span>
                                                    @else
                                                        <div class="dropdown">
                                                            <button aria-expanded="false" aria-haspopup="true" class="btn ripple btn-secondary"
                                                            data-toggle="dropdown" id="dropdownMenuButton" type="button">{{ __('user.permissions') }} <i class="fas fa-caret-down ml-1"></i></button>
                                                            <div  class="dropdown-menu tx-13">
                                                                @foreach ($user->permissions as $item)
                                                                    <a class="dropdown-item" href="#">{{ $item->name }}</a>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    @endif

                                                </td>
                                                <td class="d-flex">
                                                    <a href="" class="btn btn-primary ml-2 text-light">
                                                        <i class="fas fa-eye"></i>
													</a>
                                                    <a class="btn btn-info ml-2 text-light"
                                                        onclick=""><i
                                                            class="las la-pen"></i></a>
                                                    <form action="" method="POST">
                                                        @csrf
                                                        <input type="hidden" name="id" value="">
                                                        <button class="btn btn-danger" type="submit"><i class="las la-trash"></i></button>
                                                    </form>
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
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
