<?php

use Illuminate\Support\Facades\Route;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
Route::group( [ 'prefix' => LaravelLocalization::setLocale(), 'middleware' => [ 'localeSessionRedirect', 'localizationRedirect', 'localeViewPath' ]],
    function(){
        //Auth::routes(['register'=>false]);
        Route::group(['middleware'=>'auth'], function () {
            //invoices routes
            Route::get('/invoice/all',[App\Http\Controllers\InvoiceController::class,'index'])->name('invoice.all');
            Route::get('/invoice/paid',[App\Http\Controllers\InvoiceController::class,'getPaid'])->name('invoice.paid');
            Route::get('/invoice/archive',[App\Http\Controllers\InvoiceController::class,'getArchived'])->name('invoice.archive');
            Route::get('/invoice/paid/partially',[App\Http\Controllers\InvoiceController::class,'getPartiallyPaid'])->name('invoice.paid.partially');
            Route::get('/invoice/notpaid',[App\Http\Controllers\InvoiceController::class,'getNotPaid'])->name('invoice.notPaid');
            Route::get('/invoice/show/{id}',[App\Http\Controllers\InvoiceController::class,'show'])->name('invoice.show');
            Route::get('/invoice/create',[App\Http\Controllers\InvoiceController::class,'create'])->name('invoice.create');
            Route::post('/invoice/store',[App\Http\Controllers\InvoiceController::class,'store'])->name('invoice.store');
            Route::post('/invoices/delete',[App\Http\Controllers\InvoiceController::class,'destroy'])->name('invoice.destroy');
            Route::get('/invoices/edit/{id}',[App\Http\Controllers\InvoiceController::class,'edit'])->name('invoice.edit');
            Route::post('/invoice/update',[App\Http\Controllers\InvoiceController::class,'update'])->name('invoice.update');
            Route::get('/invoice/get/products/{id}',[App\Http\Controllers\InvoiceController::class,'getDepartmentProducts'])->name('invoice.getProducts');
            Route::get('/invoice/getInvoiceInfo/{id}',[App\Http\Controllers\InvoiceController::class,'getInfo'])->name('invoice.getInvoiceInfo');
            Route::get('/invoice/{invoice_id}/attacment/{attach_id}/download',[\App\Http\Controllers\InvoiceController::class,'downloadAttachment'])->name('attach.download');
            Route::get('/invoice/{invoice_id}/attacment/{attach_id}/view',[\App\Http\Controllers\InvoiceController::class,'viewAttachment'])->name('attach.view');
            Route::delete('/invoice/{invoice_id}/attacment/{attach_id}/delete',[\App\Http\Controllers\InvoiceController::class,'deleteAttachment'])->name('attach.delete');
            Route::delete('/invoice/delete/archived',[\App\Http\Controllers\InvoiceController::class,'deleteArchived'])->name('delete.archived');
            Route::post('/invoice/archive/restore',[\App\Http\Controllers\InvoiceController::class,'restoreArchived'])->name('restore.archived');
            Route::post('/invoice/attach/add',[\App\Http\Controllers\InvoiceController::class,'addAttach'])->name('attach.add');
            // Route::get('/invoice/send/mail',[\App\Http\Controllers\InvoiceController::class,'sendMail']);
            Route::get('/invoices/export',[\App\Http\Controllers\InvoiceController::class,'exportInvoices'])->name('invoices.export');

            //invoice reports
            Route::get('/invoice/report', [\App\Http\Controllers\ReportController::class,'index'])->name('report.index');
            Route::post('/report/range/search', [\App\Http\Controllers\ReportController::class,'searchRange'])->name('report.search.range');
            Route::post('/report/number/search', [\App\Http\Controllers\ReportController::class,'searchNumber'])->name('report.search.number');
        });
});
