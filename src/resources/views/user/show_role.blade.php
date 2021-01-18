@extends('layouts.master')
@section('css')

@endsection
@section('title')
    {{ __('role.show role')  }}
@endsection
@section('content')
    <!-- row -->
    <div class="row row-sm mt-2">
        <div class="col-md-12 col-xl-12">
            <div class=" main-content-body-invoice">
                <div class="card card-invoice">
                    {{-- start of edit role modal --}}
                    @if ($errors->any())
                        <div class="alert alert-danger my-2">
                            @foreach ($errors->all() as $err)
                                <p>{{ $err }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (session('success') !== null)
                        <div class="alert alert-success my-2">{{ session()->get('success') }}</div>
                    @endif
                    <div class="my-3">
                        <!-- Basic modal -->
                        <form method="POST" action="{{ route('role.update',$role->id) }}"  class="modal" id="modaldemo8">
                            @method('put')
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{ __('role.update') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">{{ __('role.name') }}</label>
                                            <input type="hidden" name="id" value="{{ $role->id }}">
                                            <input class="form-control" type="text" value="{{ $role->name }}" id="name" name="name">
                                        </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">{{ __('role.save') }}</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('role.cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- end basic modal -->
                    </div>
                    {{-- end of edit user modal --}}

                    <div class="card-body">
                        {{-- main details --}}
                        <div class="invoice-header">
                            <h1 class="invoice-title">{{ __('role.role') }}</h1>
                        </div>
                        <div class="row mg-t-20" id="printedArea">
                            <div class="col-md">

                                <p><a class="modal-effect btn-block btn btn-info ml-2 " data-effect="effect-scale" data-toggle="modal" href="#modaldemo8"><i class="las la-pen"></i>{{ __('role.update') }}</a></p>
                                <p class="invoice-info-row"><span
                                        class="text-primary">{{ __('role.name') }}</span><span>{{ $role->name}}
                                    </span>
                                </p>
                                <p class="invoice-info-row text-secondary"><span
                                        class="text-primary">{{ __('role.created_at') }}</span><span>{{ $role->created_at }}
                                    </span>
                                </p>
                                <p class="invoice-info-row text-secondary"><span
                                        class="text-primary">{{ __('role.updated_at') }}</span><span>
                                            {{ $role->updated_at }}
                                    </span>
                                </p>
                            </div>
                        </div>
                        {{-- view the role users --}}
                        <h3 class="invoice-title mb-2 mt-4">{{ __('role.who own this role') }}</h3>
                        <div class="table-responsive mg-t-40">
                            <table class="table table-invoice border text-md-nowrap mb-0">
                                <thead>
                                    <tr>
                                        <th class="">#</th>
                                        <th class="">{{ __('role.name') }}</th>
                                        <th class="">{{ __('role.email') }}</th>
                                        <th class="">{{ __('role.status') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($role->users as $user)
                                        <tr>
                                            <td>{{ $loop->index}}</td>
                                            <td class="tx-right text-secondary">{{ $user->name }}</td>
                                            <td class="tx-right text-secondary">{{ $user->email}}</td>
                                            @switch($user->status)
                                                @case('active')
                                                <td class="text-center">
                                                    <span class="label text-success d-flex">
                                                        <div class="dot-label bg-success ml-1"></div>{{ __('role.active') }}
                                                    </span>
                                                </td>
                                                @break
                                                @default
                                                <td class="text-center">
                                                    <span class="label text-muted d-flex">
                                                        <div class="dot-label bg-gray-300 ml-1"></div>
                                                        {{ __('role.inactive') }}
                                                    </span>
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
        </div><!-- COL-END -->
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
    <!-- main-content closed -->
@endsection
@section('js')

@endsection
