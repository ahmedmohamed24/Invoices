<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\DepartmentController;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group( [ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        //only for logging
        Auth::routes();
        //Auth::routes(['register'=>false]);
        Route::group(['middleware'=>'auth'], function () {
            //departments routes
            Route::put('department/update',[\App\Http\Controllers\DepartmentController::class,'customUpdate'])->name('department.update.custom');
            Route::resource('department', DepartmentController::class);
            //products routes
            Route::put('product/update',[\App\Http\Controllers\ProductController::class,'customUpdate'])->name('product.update.custom');
            Route::resource('product', ProductController::class);

            Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
        });
});
