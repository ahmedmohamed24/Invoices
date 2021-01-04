
@extends('layouts.master')
@section('css')
@endsection
@section('title')
    {{ __('product.products') }}
@endsection
@section('content')
    @if ($errors->any())
        <div class="alert alert-danger mt-2">
            @foreach ($errors->all() as $error)
                <p class="my-1">{{ $error }}</p>
            @endforeach
        </div>

    @endif
    @if (session('message') !== null)
        <div class="alert alert-success mt-2" role="alert">
            {{ session('message') }}
        </div>
    @endif
				<!-- row opened -->
				<div class="row row-sm">
					<div class="col-xl-12">
						<div class="card">
							<div class="card-header pb-0">
								<div class="d-flex justify-content-between">
									<h4 class="card-title mg-b-0">{{ __('product.all products') }}</h4>
								</div>
                            </div>
                            {{-- create new product modal --}}
                            <div class="w-50 mt-3 mr-2">
                                <a class="modal-effect btn btn-success btn-block" data-effect="effect-scale" data-toggle="modal"
                                    href="#modaldemo1">{{ __('product.add prduct') }}</a>
                            </div>
                            <div class="modal" id="modaldemo1">
                                <div class="modal-dialog" role="document">
                                    <form id="homeForm" action="{{ route('product.store') }}" method="POST"
                                        class="modal-content modal-content-demo" enctype="multipart/form-data">
                                        @csrf

                                        <div class="modal-header">
                                            <h6 class="modal-title">{{ __('product.add prduct') }}</h6><button aria-label="Close"
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
                                                                    <input class="form-control" placeholder="{{ __('product.title') }}"
                                                                        type="text" name="title">
                                                                </div>
                                                                <div class="form-group">
                                                                    <input class="form-control" placeholder="{{ __('product.price') }}"
                                                                        type="number" name="price">
                                                                </div>
                                                                <div class=" mb-2">
                                                                    <div class="custom-file">
                                                                        <input class="custom-file-input" name="img" id="customFile"
                                                                            type="file"> <label class="custom-file-label"
                                                                            for="customFile">{{ __('product.image') }}</label>
                                                                    </div>
                                                                </div>
                                                                <select class="form-control mb-2" required name="department">
                                                                    <option disabled selected value="-1">
                                                                        {{ __('product.select department') }}
                                                                    </option>
                                                                    @foreach ($departments as $department)
                                                                        <option class="dropdown-item" value="{{ $department->id }}">
                                                                            {{ $department->title }}
                                                                        </option>
                                                                    @endforeach
                                                                </select>
                                                                <div class="form-group">
                                                                    <textarea class="form-control"
                                                                        placeholder="{{ __('product.description') }}" rows="3"
                                                                        name="description"></textarea>
                                                                </div>
                                                                <div class="alert alert-success mg-y-1 succesContainer d-none" role="alert">
                                                                </div>
                                                                <div class="alert alert-danger mg-y-1 errorContainer d-none" role="alert">
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

							<div class="card-body">
								<div class="table-responsive">
									<table class="table mg-b-0 text-md-nowrap table-hover">
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
                                                    <td>{{ $loop->iteration}}</td>
                                                    <td><img src="{{ asset($product->img) }}" alt="{{ $product->title }}"></td>
                                                    <td>{{ $product->title }}</td>
                                                    <td>{{ $product->description }}</td>
                                                    <td>{{ $product->price }}</td>
                                                    <td>{{ $product->department->title }}</td>

                                                    <td class="d-flex">
                                                        <a class="btn btn-info ml-2 text-light"
                                                            onclick="event.preventDefault();showEditModal({{ $product->id }});"><i
                                                                class="las la-pen"></i></a>
                                                        <form action="{{ route('product.destroy', $product->id) }}" method="POST">
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
					<!--/div-->
				</div>
                <!-- /row -->
<div class="">
</div>
{{-- pagination --}}
<div class="d-flex justify-content-center">
    <ul class="pagination pagination-circled mb-0 text-center "data-placement="top" data-toggle="tooltip" title="{{ $products->total() }} total items">
        <li class="page-item @if (!$products->hasMorePages()) disabled @endif"><a class="page-link" href="{{ $products->nextPageUrl() }}"><i class="icon ion-ios-arrow-forward"></i></a></li>
        <li class="page-item @if (!$products->hasMorePages())
        disabled
        @endif"><a class="page-link" href="#">{{ $products->currentPage()+1 }}</a></li>
        <li class="page-item active"><a class="page-link" href="{{ $products->previousPageUrl() }}">{{ $products->currentPage() }}</a></li>
        <li class="page-item @if ($products->onFirstPage()) disabled @endif"><a class="page-link " href="{{ $products->previousPageUrl() }}"><i class="icon ion-ios-arrow-back"></i></a></li>
    </ul>
</div>
	</div>
			<!-- Container closed -->
		</div>
        <!-- main-content closed -->
    {{-- Update Model --}}
    <div class="hidden">
        <a class="modal-effect hidden" id="openEditModel" data-effect="effect-scale" data-toggle="modal"
            href="#modaldemo5">Update</a>
    </div>
    <form method="POST" action="{{ route('product.update.custom') }}" id="updateForm" class="w-75 my-4" enctype="multipart/form-data">

        <div class="modal" id="modaldemo5">
            <div class="modal-dialog" role="document">
                <div class="modal-content modal-content-demo">
                    <div class="modal-header">
                        <h6 class="modal-title">{{ __('settings.update') }}</h6><button aria-label="Close" class="close"
                            data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body">

                        @csrf
                        @method('PUT')
                        <input type="hidden" name="product" id="product-update-id">
                        <div class="form-group">
                            <input class="form-control" value="" type="text" id="product-update-title" name="title">
                        </div>
                        <div class="form-group">
                            <input class="form-control" value="" type="number" id="product-update-price" name="price">
                        </div>
                        <select class="form-control mb-2" required name="department">
                            <option value="-1" disabled selected>{{ __('product.select department') }}</option>
                            @foreach ($departments as $department)
                                <option class="dropdown-item" value="{{ $department->id }}">
                                    {{ $department->title }}
                                </option>
                            @endforeach
                        </select>
                        <div class="">
                            <img class="img-fluid" src="" alt="" id="product-update-img">
                        </div>
                        <div class=" my-2">
                            <div class="custom-file">
                                <input class="custom-file-input" name="img" id="customFile1" type="file"> <label
                                    class="custom-file-label" for="customFile1">{{ __('product.image') }}</label>
                            </div>
                        </div>
                        <div class="form-group mt-2">
                            <textarea class="form-control" value="" rows="3" id="product-update-description"
                                name="description"></textarea>
                        </div>
                        <div class="alert alert-success mg-y-1 succesContainerUpdate d-none" role="alert">
                        </div>
                        <div class="alert alert-danger mg-y-1 errorContainerUpdate d-none" role="alert">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn ripple btn-primary" type="submit">{{ __('settings.save') }}</button>
                        <button class="btn ripple btn-secondary" data-dismiss="modal" type="button">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

@endsection
@section('js')
<script>
        // for displaying modal to update data
        function showEditModal(id) {
            $.ajax({
                type: 'GET',
                enctype: 'multipart/form-data',
                url: window.location.origin + `/product/${id}`,
                data: null,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    document.getElementById('openEditModel').click();
                    if (data.status === 200) {
                        document.getElementById('product-update-id').value = data.data.id;
                        document.getElementById('product-update-title').value = data.data.title;
                        document.getElementById('product-update-description').value = data.data.description;
                        document.getElementById('product-update-price').value = data.data.price;
                        //document.getElementById('product-update-form').action = window.location.origin + `/product/` + data.data.id;
                        document.getElementById('product-update-img').src = window.location.origin +'/'+ data.data .img;
                        document.getElementById('product-update-img').alt = data.data.title;
                    } else {

                    }
                },
            });
        }
        //updating a modal
        $('#updateForm').submit((e) => {
            e.preventDefault();
            let formData = new FormData($('#updateForm')[0]);
            //make the both containers for success messages and error messages empty and hidden again
            const successContainer = document.querySelector('.succesContainerUpdate');
            const errorContainer = document.querySelector('.errorContainerUpdate');
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
                url: "{{ route('product.update.custom') }}",
                data: formData,
                processData: false,
                contentType: false,
                cache: false,
                success: function(data) {
                    console.log(data)
                    if (data.status == 200) {
                        successContainer.classList.remove('d-none');
                        successContainer.innerHTML = data.msg;
                    } else {
                        console.log(errorContainer);
                        errorContainer.classList.remove('d-none');
                        for (let msg in data.msg) {
                            var temp = document.createElement('P');
                            temp.innerHTML = data.msg[msg][0];
                            errorContainer.appendChild(temp)
                        }

                    }
                },

            });
        })
        //for creating new Product
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
                url: "{{ route('product.store') }}",
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
