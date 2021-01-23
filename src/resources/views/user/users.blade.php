@extends('layouts.master')
@section('title')
    {{ __('user.users') }}
@endsection
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
                    {{-- start of creating new user modal --}}
                    @if ($errors->any())
                        <div class="alert alert-danger my-2">
                            @foreach ($errors->all() as $err)
                                <p>{{ $err }}</p>
                            @endforeach
                        </div>
                    @endif
                    @if (session('error') !== null)
                        <div class="alert alert-danger my-2">{{ session()->get('error') }}</div>
                    @endif
                    @if (session('success') !== null)
                        <div class="alert alert-success my-2">{{ session()->get('success') }}</div>
                    @endif
                    {{-- creating new user modal --}}
                    @can('add_user')
                        <div class="my-3">
                            <div class="col-sm-6 col-md-4 col-xl-3">
                                <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale"
                                    data-toggle="modal" href="#modaldemo8">{{ __('user.add user') }}</a>
                            </div>
                            <!-- Basic modal -->
                            <form method="POST" action="{{ route('user.store') }}" class="modal" id="modaldemo8">
                                @csrf
                                <div class="modal-dialog" role="document">
                                    <div class="modal-content modal-content-demo">
                                        <div class="modal-header">
                                            <h6 class="modal-title">{{ __('user.add user') }}</h6><button aria-label="Close"
                                                class="close" data-dismiss="modal" type="button"><span
                                                    aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="userName">{{ __('user.name') }}</label>
                                                <input class="form-control" type="text" value="{{ old('name') }}" id="userName"
                                                    name="name">
                                            </div>
                                            <div class="form-group">
                                                <label for="userEmail">{{ __('user.email') }}</label>
                                                <input class="form-control" type="text" value="{{ old('email') }}"
                                                    id="userEmail" name="email">
                                            </div>
                                            <div class="form-group">
                                                <label for="password">{{ __('user.password') }}</label>
                                                <input class="form-control" type="password" id="password" name="password">
                                            </div>
                                            <div class="form-group">
                                                <label for="password_confirm">{{ __('user.confirm password') }}</label>
                                                <input class="form-control" type="password" id="password_confirm"
                                                    name="cPassword">
                                            </div>
                                            <div class="d-flex flex-column">
                                                <label for="userStatus" class="mt-2">{{ __('user.status') }}</label>
                                                <select id="userStatus" name="status" class="form-control select2-no-search">
                                                    <option selected value="active">
                                                        {{ __('user.active') }}
                                                    </option>
                                                    <option value="inactive">
                                                        {{ __('user.inactive') }}
                                                    </option>
                                                </select>
                                            </div>
                                            @can('change_user_roles')
                                                <div class="d-flex flex-column">
                                                    <label for="userRoles" class="mt-2">{{ __('user.roles') }}</label>
                                                    <select id="userRoles" name="roles[]" class="form-control select2" multiple>
                                                        @foreach ($roles as $item)
                                                            <option value=" {{ $item }}">
                                                                {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endcan
                                            @can('change_user_permission')
                                                <div class="d-flex flex-column">
                                                    <label for="userPermissions" class="mt-2">{{ __('user.permissions') }}</label>
                                                    <select id="userPermissions" name="permissions[]" class="form-control select2"
                                                        multiple>
                                                        @foreach ($permissions as $item)
                                                            <option value="{{ $item }}">
                                                                {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>
                                            @endcan
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="submit">{{ __('user.save') }}</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal"
                                                type="button">{{ __('user.cancel') }}</button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                            <!-- end basic modal -->
                        </div>
                    @endcan
                    {{-- view users --}}
                        <div class="table-responsive">
                            <table class="table table-hover mb-0 text-md-nowrap">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>{{ __('user.name') }}</th>
                                        <th>{{ __('user.email') }}</th>
                                        <th>{{ __('user.status') }}</th>
                                        <th>{{ __('user.permissions') }}</th>
                                        <th>{{ __('user.role') }}</th>
                                        <th>{{ __('user.operations') }}</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $user)
                                        <tr>
                                            <th scope="row">{{ $loop->index }}</th>
                                            <td>{{ $user->name }}</td>
                                            <td>{{ $user->email }}</td>
                                            @switch($user->status)
                                                @case('active')
                                                <td class="text-center">
                                                    <span class="label text-success d-flex">
                                                        <div class="dot-label bg-success ml-1"></div>{{ $user->status }}
                                                    </span>
                                                </td>
                                                @break
                                                @default
                                                <td class="text-center">
                                                    <span class="label text-muted d-flex">
                                                        <div class="dot-label bg-gray-300 ml-1"></div>{{ $user->status }}
                                                    </span>
                                                </td>
                                            @endswitch
                                            <td>
                                                @if (count($user->getrolenames()) === 0)
                                                    <span class="text-center text-secondary">{{ __('user.no roles') }}</span>
                                                @else
                                                    <select class="form-control select2-no-search">
                                                        <option selected disabled>{{ __('user.roles') }} </option>
                                                        @foreach ($user->getrolenames() as $item)
                                                            <option>
                                                                {{ $item }}
                                                            </option>
                                                        @endforeach
                                                    </select>

                                                @endif
                                            </td>
                                            <td>
                                                @if (count($user->permissions) === 0)
                                                    <span
                                                        class="text-center text-secondary">{{ __('user.no permissions') }}</span>
                                                @else
                                                    <select class="form-control select2-no-search">
                                                        <option selected disabled>{{ __('user.permissions') }}</option>
                                                        @foreach ($user->permissions as $item)
                                                            <option>
                                                                {{ $item->name }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                @endif
                                            </td>
                                            <td class="d-flex">
                                                @can('edit_users')
                                                    <a class="btn btn-info ml-2 text-light"
                                                        onclick="event.preventDefault();showEditModal('{{ route('user.show', $user->id) }}')"><i
                                                            class="las la-pen"></i></a>
                                                @endcan
                                                @can('delete_user')
                                                    <form action="{{ route('user.destroy', $user->id) }}" method="POST">
                                                        @csrf
                                                        @method('delete')
                                                        <button class="btn btn-danger" type="submit"><i
                                                                class="las la-trash"></i></button>
                                                    </form>
                                                @endcan
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>

                        <div class="d-flex justify-content-center align-items-center my-3">{!! $users->render() !!}</div>
                    </div>
                </div>
            </div>
        </div>
        <!-- row closed -->
        </div>
        <!-- Container closed -->
        </div>
        <!-- main-content closed -->
        <!-- edit modal -->
        @can('edit_users')
            <a class="hidden" id="showEditModal" data-effect="effect-scale" data-toggle="modal" href="#modaldemo1">hidden</a>
            <form method="POST" action="{{ route('user.custom.update') }}" class="modal" id="modaldemo1">
                @csrf
                @method('PUT')
                <div class="modal-dialog" role="document">
                    <div class="modal-content modal-content-demo">
                        <div class="modal-header">
                            <h6 class="modal-title">{{ __('user.edit user') }}</h6><button aria-label="Close" class="close"
                                data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                        </div>
                        <input type="hidden" name="id" id="userId-edit">
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="userName">{{ __('user.name') }}</label>
                                <input class="form-control" type="text" value="" id="userName-edit" name="name">
                            </div>
                            <div class="form-group">
                                <label for="userEmail">{{ __('user.email') }}</label>
                                <input class="form-control" type="text" value="" id="userEmail-edit" name="email">
                            </div>
                            @can('change_user_status')
                                <div class="d-flex flex-column">
                                    <label for="userStatus-edit">{{ __('user.status') }}</label>
                                    <select id="userStatus-edit" name="status" class="form-control">
                                        <option value="active" id="activeStatus">
                                            {{ __('user.active') }}
                                        </option>
                                        <option value="inactive" id="inactiveStatus">
                                            {{ __('user.inactive') }}
                                        </option>
                                    </select>
                                </div>
                            @endcan
                            @can('change_user_roles')
                                <div class="d-flex flex-column">
                                    <label for="userRoles-edit">{{ __('user.roles') }}</label>
                                    <select id="userRoles-edit" name="roles[]" class="form-control" multiple="multiple">
                                        @foreach ($roles as $item)
                                            <option value="{{ $item }}" id="role-option-{{ $item }}">
                                                {{ $item }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan
                            @can('change_user_permission')
                                <div class="d-flex flex-column">
                                    <label for="userPermissions-edit">{{ __('user.permissions') }}</label>
                                    <select id="userPermissions-edit" name="permissions[]" class="form-control select2" multiple>
                                        @foreach ($permissions as $item)
                                        <option value="{{ $item }}" id="permission-option-{{ $item }}">
                                            {{ $item }}
                                        </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endcan
                        </div>
                        <div class="modal-footer">
                            <button class="btn ripple btn-primary" type="submit">{{ __('user.save') }}</button>
                            <button class="btn ripple btn-secondary" data-dismiss="modal"
                                type="button">{{ __('user.cancel') }}</button>
                        </div>
                    </div>
                </div>
            </form>
        @endcan
        <!-- End edit modal -->
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
        function showEditModal(route) {
            //fetch the data
            fetch(route)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 200) {
                        //remove old selections if there is any
                        let allOptions = document.getElementById('userPermissions-edit').children;
                        for (let i = 0; i < allOptions.length; i++) {
                            allOptions[i].removeAttribute('selected');
                        }
                        let allRoles = document.getElementById('userRoles-edit').children;
                        for (let i = 0; i < allRoles.length; i++) {
                            allRoles[i].removeAttribute('selected');
                        }

                        //append data to form
                        document.getElementById("userId-edit").value = data.data.id;
                        document.getElementById("userName-edit").value = data.data.name;
                        document.getElementById("userEmail-edit").value = data.data.email;
                        // document.getElementById("modaldemo1").action=window.location.origin+'user/custom/update';
                        switch (data.data.status) {
                            case 'active':
                                document.getElementById("activeStatus").setAttribute('selected', 'selected');
                                document.getElementById("inactiveStatus").removeAttribute('selected');
                                break;
                            default:
                                document.getElementById("inactiveStatus").setAttribute('selected', 'selected');
                                document.getElementById("activeStatus").removeAttribute('selected');
                        }
                        let roles = data.data.roles;
                        for (let i = 0; i < roles.length; i++) {
                            document.getElementById(`role-option-${roles[i].name}`).setAttribute('selected',
                                'selected');
                        }
                        let permissions = data.data.permissions;
                        for (let i = 0; i < permissions.length; i++) {
                            document.getElementById(`permission-option-${permissions[i].name}`).setAttribute('selected',
                                'selected');
                        }
                        //call select2 plugin to render
                        $('#userStatus-edit').select2();
                        $('#userPermissions-edit').select2();
                        $('#userRoles-edit').select2();
                        //show edit form
                        document.getElementById('showEditModal').click();
                    } else {
                        alert('error');
                    }
                });

        }

    </script>
@endsection
