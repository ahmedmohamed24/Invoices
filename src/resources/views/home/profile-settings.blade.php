@extends('layouts.master')
@section('title')
    {{ __('main.account settings') }}
@endsection
@section('css')
@endsection
@section('page-header')
    @if (session('msg')!==null)
        <p class="my-2 alert alert-success">{{ __('main.successfully updated') }}</p>
    @endif
@endsection
@section('content')
				<!-- row -->
				<div class="row bg-white mt-2 p-3">
                    <form action="" method="POST" >
                        @csrf
                        <div class="form-group">
                            <label for="name">{{ __('main.Name') }}</label>
                            <input type="text" value="{{ Auth::user()->name }}" name='name' id="name" class="form-control">
                            @error('name')
                                <p class="alert alert-danger my-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="password">{{ __('main.old password') }}</label>
                            <input type="password" placeholder="" id="password" name="password" class="form-control">
                            @error('password')
                                <p class="alert alert-danger my-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="newPassword">{{ __('main.new password') }}</label>
                            <input type="password" placeholder="" id="newPassword" name="newPassword" class="form-control">
                            @error('newPassword')
                                <p class="alert alert-danger my-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="rePass">{{ __('main.re-password') }}</label>
                            <input type="password" placeholder=""name="rePassword" id="rePass" class="form-control">
                            @error('rePassword')
                                <p class="alert alert-danger my-2">{{ $message }}</p>
                            @enderror
                        </div>
                        <button class="btn btn-primary waves-effect waves-light w-md" type="submit">{{ __('main.save') }}</button>

                    </form>
				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
@endsection
