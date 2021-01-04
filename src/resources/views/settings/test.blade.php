@extends('layouts.master')
@section('css')
@endsection
@section('title')
    {{ __('settings.departments') }}
@endsection

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            @foreach ($errors->all() as $error)
                <p class="my-1">{{ $error }}</p>
            @endforeach
        </div>

    @endif
    @if (session('message') !== null)
        <div class="alert alert-success" role="alert">
            {{ session('message') }}
        </div>
    @endif


				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('settings.departments') }}</h4>
								</div>
                            </div>
                            {{-- adding new deparment model --}}
                            <div class="w-50 mt-3">
                                <a class="modal-effect btn btn-success btn-block" data-effect="effect-scale" data-toggle="modal"
                                    href="#modaldemo1">{{ __('settings.add department') }}</a>
                            </div>
                            <!-- Basic modal -->
                            <div class="modal" id="modaldemo1">
                                <div class="modal-dialog" role="document">
                                    <form id="homeForm" action="{{ route('department.store') }}" method="POST"
                                        class="modal-content modal-content-demo">
                                        @csrf
                                        <div class="alert alert-success mg-y-1 succesContainer d-none" role="alert">
                                        </div>
                                        <div class="alert alert-danger mg-y-1 errorContainer d-none" role="alert">
                                        </div>
                                        <div class="modal-header">
                                            <h6 class="modal-title">{{ __('settings.add department') }}</h6><button aria-label="Close"
                                                class="close" data-dismiss="modal" type="button"><span
                                                    aria-hidden="true">&times;</span></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="card">
                                                <div class="card-body">
                                                    <div class="row">
                                                        <div class="col-lg-12">
                                                            <div class="bg-gray-200 p-4">
                                                                <div class="form-group">
                                                                    <input class="form-control"
                                                                        placeholder="{{ __('settings.Department Title') }}" type="text"
                                                                        name="title">
                                                                </div>
                                                                <div class="form-group">
                                                                    <textarea class="form-control"
                                                                        placeholder="{{ __('settings.Description') }}" rows="3"
                                                                        name="description"></textarea>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button class="btn ripple btn-primary" type="submit">Save</button>
                                            <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            {{-- all products view --}}
							<div class="card-body">
								<div class="table-responsive">
									<table class="table table-hover mb-0 text-md-nowrap">
										<thead>
											<tr>
                                                <th>#</th>
                                                <th>{{ __('settings.title') }}</th>
                                                <th>{{ __('settings.notes') }}</th>
                                                <th>{{ __('settings.operations') }}</th>
                                            </tr>
										</thead>
										<tbody>
                                            @foreach ($departments as $department)
                                                <tr>
                                                    <td>{{ $loop->index }}</td>
                                                    <td>{{ $department->title }}</td>
                                                    <td>{{ $department->description }}</td>
                                                    <td class="d-flex">
                                                        <a class="btn btn-info ml-2"
                                                            onclick="event.preventDefault();showEditModal({{ $department->id }});"><i
                                                                class="las la-pen"></i></a>
                                                        <form action="{{ route('department.destroy', $department->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
                                                            <button class="btn btn-danger"><i class="las la-trash"></i></button>
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
				<!-- /row -->
			</div>
			<!-- Container closed -->
		</div>
        <!-- main-content closed -->
    {{-- Update Model --}}
    <div class="hidden">
        <a class="modal-effect hidden" id="openEditModel" data-effect="effect-scale" data-toggle="modal"
            href="#modaldemo5">Update</a>
    </div>
    <form method="POST" action="" id="updateForm" class="w-75 my-4">
        @csrf
        @method('PUT')
        <div class="modal" id="modaldemo5">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('settings.update') }}</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <input value="" type="hidden" id="department" name="department">
                        <div class="form-group">
                            <input class="form-control" value="" type="text" id="departmentTitle" name="title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" value="" rows="3" id="departmentDesc"
                                name="description"></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('settings.save') }}</button>
						<button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                        {{-- <a class="btn ripple btn-secondary" href="{{ route('department.index') }}"
                            type="button">{{ __('settings.close') }}</a> --}}
                    </div>
                </div>
            </div>
        </div>
    </form>
    <!-- End of update Model -->
@endsection
@section('js')
    <script>
        // for displaying modal to update data
        function showEditModal(id) {
            $.ajax({
                type: 'GET',
                enctype: 'multipart/form-data',
                url: window.location.origin + `/department/${id}`,
                data: null,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    console.log(data);
                    document.getElementById('openEditModel').click();
                    if (data.status === 200) {
                        document.getElementById('departmentTitle').value = data.data.title;
                        document.getElementById('departmentDesc').value = data.data.description;
                        document.getElementById('department').value = data.data.id;
                        document.getElementById('updateForm').action =window.location.origin+`/department/`+ data.data.id;
                    }
                },
            });
        }
        //for creating new departmnet
        $('#homeForm').submit((e) => {
            e.preventDefault();
            let formData = new FormData($('#homeForm')[0]);
            //make the both containers for success messages and error messages empty and hidden again
            const successContainer = document.querySelector('.succesContainer');
            const errorContainer = document.querySelector('.errorContainer');
            successContainer.innerHTML = "";
            successContainer.classList.add('d-none');
            errorContainer.innerHTML = "";
            errorContainer.classList.add('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{ route('department.store') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    if (data.status == 200) {
                        successContainer.classList.remove('d-none');
                        successContainer.innerHTML = data.msg;
                    } else {
                        errorContainer.classList.remove('d-none');
                        for (let msg in data.msg) {
                            var temp = document.createElement('P');
                            temp.innerHTML = data.msg[msg];
                            errorContainer.appendChild(temp)

                        }

                    }
                },

            });
        })

    </script>
@endsection
