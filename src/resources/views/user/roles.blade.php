@extends('layouts.master')
@section('title')
    {{ __('role.roles') }}
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
                        <h4 class="card-title mg-b-0">{{ __('role.role list') }}</h4>
                        <i class="mdi mdi-dots-horizontal text-gray"></i>
                    </div>
                </div>
                <div class="card-body">
                    {{-- start of creating new role modal --}}
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
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo8">{{ __('role.add role') }}</a>
                        </div>
                        <!-- Basic modal -->
                        <form method="POST" action="{{ route('role.store') }}"  class="modal" id="modaldemo8">
                            @csrf
                            <div class="modal-dialog" role="document">
                                <div class="modal-content modal-content-demo">
                                    <div class="modal-header">
                                        <h6 class="modal-title">{{ __('role.add role') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="form-group">
                                            <label for="name">{{ __('user.name') }}</label>
                                            <input class="form-control" type="text" value="{{ old('name') }}" id="name" name="name">
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
                    {{-- end of creating new user modal --}}
                    <div class="row my-4">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('role.name') }}</th>
                                        <th class="">{{ __('role.guard name') }}</th>
                                        <th>{{ __('role.created_at') }}</th>
                                        <th>{{ __('role.updated_at') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <th scope="row">{{ $loop->index }}</th>
                                            <td class="text-primary">{{ $role->name }}</td>
                                            <td>{{ $role->guard_name }}</td>
                                            <td class="text-secondary" dir="ltr">{{ Illuminate\Support\Carbon::parse($role->created_at)->diffForHumans(now()) }}</td>
                                            <td class="text-secondary" dir="ltr">
                                                @if ($role->updated_at === null || $role->updated_at === $role->created_at)
                                                    {{ __('role.never updated') }}
                                                @else
                                                    {{  Illuminate\Support\Carbon::parse($role->updated_at)->diffForHumans(now())  }}
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                <a href="{{ route('role.show',$role->id) }}" title="show the role users"
                                                    class="btn btn-primary ml-2 text-light">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                                <form action="{{ route('role.destroy',$role->id) }}" method="POST">
                                                    @csrf
                                                    @method('delete')
                                                    <input type="hidden" name="id" value="{{ $role->id }}">
                                                    <button  class="btn btn-danger" type="submit"title="delete this role"><i
                                                            class="las la-trash"></i></button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach

                                    <div class="d-flex justify-content-center align-items-center my-3">{!! $roles->render() !!}</div>
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
