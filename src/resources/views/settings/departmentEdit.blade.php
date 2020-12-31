@extends('layouts.master')
@section('css')
@endsection
@section('title')
   {{ __('settings.update') }}
@endsection
@section('content')
                    <form method="POST" action="{{ route('department.update',$department->id) }}" class="w-75 my-4">
                        @csrf
                        @method('PUT')
						<div class="card">
							<div class="card-body">
								<div class="main-content-label my-3">
                                    {{ __('settings.update') }}
								</div>
								<div class="row row-sm">
									<div class="col-lg">
                                        <div class="form-group">
											<input class="form-control" placeholder="{{ $department->title }}" type="text"name="title">
                                        </div>
                                        @error('title')
                                            {{ $message }}
                                        @enderror
										<div class="form-group">
									        <textarea class="form-control" placeholder="{{ $department->description }}" rows="3" name="description"></textarea>
                                        </div>
                                        @error('title')
                                            {{ $message }}
                                        @enderror
									</div>
								</div>
							</div>
                        </div>
                        <button class="btn ripple btn-primary" type="submit">Save</button>
						<a class="btn ripple btn-secondary" href="{{ route('department.index') }}" type="button">Close</a>

					</form>
@endsection
@section('js')
@endsection
