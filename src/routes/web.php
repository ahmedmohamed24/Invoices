<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/


Route::group( [ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        //only for logging
        Auth::routes(['register'=>false]);
        Route::group(['middleware'=>'auth'], function () {
            //available links for logged users

            //invoices routes
            Route::get('/invoice/all',[App\Http\Controllers\InvoiceController::class,'index'])->name('invoice.all');
            Route::get('/invoice/show/{id}',[App\Http\Controllers\InvoiceController::class,'show'])->name('invoice.show');
            Route::get('/invoice/create',[App\Http\Controllers\InvoiceController::class,'create'])->name('invoice.create');
            Route::post('/invoice/store',[App\Http\Controllers\InvoiceController::class,'store'])->name('invoice.store');
            Route::post('/invoices/delete',[App\Http\Controllers\InvoiceController::class,'destroy'])->name('invoice.destroy');
            Route::get('/invoices/edit/{id}',[App\Http\Controllers\InvoiceController::class,'edit'])->name('invoice.edit');
            Route::post('/invoice/update',[App\Http\Controllers\InvoiceController::class,'update'])->name('invoice.update');


            Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
            Route::get('/{page}', [App\Http\Controllers\AdminController::class,'index']);
        });
});
