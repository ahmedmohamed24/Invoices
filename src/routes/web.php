<?php

use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

Route::group(
    ['prefix' => LaravelLocalization::setLocale(), 'middleware' => ['localeSessionRedirect', 'localizationRedirect', 'localeViewPath']],
    function () {
        //only for logging
        Auth::routes(['register' => false]);
        Route::group(['middleware' => 'auth'], function () {
            //departments routes
            Route::put('department/update', [\App\Http\Controllers\DepartmentController::class, 'customUpdate'])->middleware('can:edit department')->name('department.update.custom');
            Route::resource('department', DepartmentController::class);
            //products routes
            Route::put('product/update', [\App\Http\Controllers\ProductController::class, 'customUpdate'])->name('product.update.custom');
            Route::resource('product', ProductController::class);

            Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
            Route::get('/profile/settings', [App\Http\Controllers\HomeController::class, 'getProfileSettings'])->name('profile.settings');
            Route::post('/profile/settings', [App\Http\Controllers\HomeController::class, 'saveProfileSettings'])->name('profile.save');
        });
    }
);
