<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;


Route::group( [ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        Route::group(['middleware'=>'auth'], function () {
            Route::resource('user', \App\Http\Controllers\UserController::class);
            Route::resource('permission', \App\Http\Controllers\UserPermissionController::class);
            Route::resource('role', \App\Http\Controllers\UserRoleController::class);
        });
});
