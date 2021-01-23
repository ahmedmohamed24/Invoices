
@extends('layouts.master')
@section('title')
    {{ __('permission.permissions') }}
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
                        <h4 class="card-title mg-b-0">{{ __('permission.permission list') }}</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    {{-- start of creating new permission modal --}}
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
                        <div class="col-sm-6 col-md-4 col-xl-3">
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{ __('permission.add permission') }}</a>
                        </div>
                        <!-- Basic modal -->
                        <form method="POST" action="{{ route('permission.store') }}"  class="modal" id="modaldemo8">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{ __('permission.add permission') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">{{ __('user.name') }}</label>
                                            <input class="form-control" type="text" value="{{ old('name') }}" id="name" name="name">
                                        </div>
                                    <div class="modal-footer">
                                        <button class="btn ripple btn-primary" type="submit">{{ __('permission.save') }}</button>
                                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">{{ __('permission.cancel') }}</button>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!-- end basic modal -->
                    </div>
                    {{-- end of creating new user modal --}}
                    <div class="row my-4">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('permission.name') }}</th>
                                        <th class="">{{ __('permission.guard name') }}</th>
                                        <th>{{ __('permission.created_at') }}</th>
                                        <th>{{ __('permission.updated_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($permissions as $permission)
                                        <tr>
                                            <th scope="row">{{ $loop->index }}</th>
                                            <td class="text-primary">{{ $permission->name }}</td>
                                            <td>{{ $permission->guard_name }}</td>
                                            <td class="text-secondary" dir="ltr">{{ Illuminate\Support\Carbon::parse($permission->created_at)->diffForHumans(now()) }}</td>
                                            <td class="text-secondary" dir="ltr">
                                                @if ($permission->updated_at === null || $permission->updated_at === $permission->created_at)
                                                    {{ __('permission.never updated') }}
                                                @else
                                                    {{  Illuminate\Support\Carbon::parse($permission->updated_at)->diffForHumans(now())  }}
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{ route('permission.show',$permission->id) }}" title="show the permission users"
                                                    class="btn btn-primary ml-2 text-light">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                @can('remove_permission')
                                                    <form action="{{ route('permission.destroy',$permission->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <input type="hidden" name="id" value="{{ $permission->id }}">
                                                        <button  class="btn btn-danger" type="submit"title="delete this permission"><i
                                                                class="las la-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach

                                    <div class="d-flex justify-content-center align-items-center my-3">{!! $permissions->links() !!}</div>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- row closed -->
    </div>
    <!-- Container closed -->
    </div>
@endsection
@section('js')

@endsection
