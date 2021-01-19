<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group( [ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        Route::group(['middleware'=>'auth'], function () {
            //custom route for update only
            Route::put('user/custom/update',[\App\Http\Controllers\UserController::class,'customUpdate'] )->name('user.custom.update');
            Route::resource('user', \App\Http\Controllers\UserController::class);
            Route::resource('permission', \App\Http\Controllers\UserPermissionController::class);
            Route::resource('role', \App\Http\Controllers\UserRoleController::class);
        });
});
