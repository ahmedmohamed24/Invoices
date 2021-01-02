@extends('layouts.master')
@section('css')
<!-- Internal Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('title')
   {{ __('product.products') }}
@endsection

@section('page-header')
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
        {{-- adding new product modal --}}
        <div class="w-50 mt-3">
			<a class="modal-effect btn btn-success btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo1">{{ __('product.add prduct') }}</a>
        </div>
		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
                <form id="homeForm" action="{{ route('product.store') }}"  method="POST" class="modal-content modal-content-demo">
                    @csrf
                    <div class="alert alert-success mg-y-1 succesContainer d-none" role="alert">
                    </div>
                    <div class="alert alert-danger mg-y-1 errorContainer d-none" role="alert">
                    </div>
					<div class="modal-header">
						<h6 class="modal-title">{{ __('product.add prduct') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
					<div class="modal-body">
                        <div class="card">
							<div class="card-body">
								<div class="row">
									<div class="col-lg-12">
										<div class="bg-gray-200 p-4">
											<div class="form-group">
												<input class="form-control" placeholder="{{ __('product.title') }}" type="text"name="title">
                                            </div>
                                            <div class="form-group">
												<input class="form-control" placeholder="{{ __('product.price') }}" type="number" name="price">
											</div>
                                            <div class=" mb-2">
                                                    <div class="custom-file">
                                                        <input class="custom-file-input" name="img" id="customFile" type="file"> <label class="custom-file-label" for="customFile">{{ __('product.image') }}</label>
                                                    </div>
                                            </div>
                                            <select class="form-control mb-2" required name="department">
                                                <option disabled default value="-1">{{ __('product.select department') }}</option>
                                                @foreach ($departments as $department)
                                                    <option class="dropdown-item" value="{{ $department->id }}">{{ $department->title }}</option>
                                                @endforeach
                                            </select>
											<div class="form-group">
										        <textarea class="form-control" placeholder="{{ __('product.description') }}" rows="3" name="description"></textarea>
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


@endsection
@section('content')
        				<!-- row opened -->
				<div class="row row-sm mt-3">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('product.all products') }}</h4>
								</div>
							</div>
							<div class="card-body">
								<div class="table-responsive hoverable-table w-100">
									<table id="example-delete" class="table text-md-nowrap">
										<thead>
											<tr>
												<th>#</th>
                                                <th>{{ __('product.image') }}</th>
												<th>{{ __('product.title') }}</th>
												<th>{{ __('product.description') }}</th>
                                                <th>{{ __('product.price') }}</th>
                                                <th>{{ __('product.department') }}</th>
                                                <th>{{ __('product.operations') }}</th>

											</tr>
										</thead>
										<tbody>
                                                @foreach ($products as $product)
    											<tr>
                                                    <td>{{ $loop->index }}</td>
                                                    <td><img src="{{asset(($product->img))}}" alt="{{ $product->title}}"></td>
												    <td>{{ $product->title}}</td>
                                                    <td>{{ $product->description}}</td>
                                                    <td>{{ $product->price}}</td>
                                                    <td>{{ $product->department->title}}</td>

												    <td class="d-flex">
												        <a class="btn btn-info ml-2" onclick="event.preventDefault();showEditModal({{ $product->id }});"><i class="las la-pen"></i></a>
                                                        <form action="{{ route('product.destroy',$product->id) }}" method="POST">
                                                            @method('DELETE')
                                                            @csrf
												            <button class="btn btn-danger"><i class="las la-trash"></i></button>
                                                        </form>


                                                    </td>
			    								</tr>
                                                @endforeach
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
		<a class="modal-effect hidden" id="openEditModel" data-effect="effect-scale" data-toggle="modal" href="#modaldemo5">Update</a>
    </div>
    <form method="POST" action="" id="updateForm" class="w-75 my-4">
        @csrf
        @method('PUT')
		<div class="modal" id="modaldemo5">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">{{ __('product.update') }}</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
					<div class="modal-body">
                        <div class="form-group">
                            <input class="form-control" value="" type="text" id="productTitle" name="title">
                        </div>
                        <div class="form-group">
                            <textarea class="form-control" value="" rows="3"id="productDesc" name="description"></textarea>
                        </div>
					</div>
					<div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('product.save') }}</button>
						<a class="btn ripple btn-secondary" href="{{ route('product.index') }}" type="button">{{ __('product.cancel') }}</a>
					</div>
				</div>
			</div>
        </div>
	</form>
	<!-- End of update Model -->
@endsection
@section('js')
<!-- Internal Data tables -->
@if (LaravelLocalization::getCurrentLocale()=="ar")
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables-rtl.js')}}"></script>
@else
    <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
@endif
{{-- <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script> --}}
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
    <script>

        // for displaying modal to update data
        function showEditModal(id){
            $.ajax({
                type: 'GET',
                enctype: 'multipart/form-data',
                url: window.location.href+`/${id}`,
                data: null,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                  document.getElementById('openEditModel').click();
                  if(data.status===200)
                  {
                    document.getElementById('productTitle').value=data.data.title;
                    document.getElementById('productDesc').value=data.data.description;
                    document.getElementById('updateForm').action=window.location.href+'/'+data.data.id;
                  }
                },
            });
        }
        //for creating new Product
        $('#homeForm').submit((e)=>{
            e.preventDefault();
            let formData= new FormData($('#homeForm')[0]);
            //make the both containers for success messages and error messages empty and hidden again
            const successContainer=document.querySelector('.succesContainer');
            const errorContainer=document.querySelector('.errorContainer');
            successContainer.innerHTML="";
            successContainer.classList.add('d-none');
            errorContainer.innerHTML="";
            errorContainer.classList.add('d-none');
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                type: 'POST',
                enctype: 'multipart/form-data',
                url: "{{route('product.store')}}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function (data) {
                    if (data.status == 200) {
                        successContainer.classList.remove('d-none');
                        successContainer.innerHTML=data.msg;
                    }else{
                        errorContainer.classList.remove('d-none');
                        for(let msg in data.msg){
                            var temp=document.createElement('P');
                            temp.innerHTML=data.msg[msg];
                            errorContainer.appendChild(temp)

                        }

                    }
                },

            });
        })

    </script>
@endsection
