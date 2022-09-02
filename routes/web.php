<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use Illuminate\Support\Facades\Route;


// Route::get('/', function () {
//     return view('welcome');
// });
Route::resource('/api/customers', 'App\Http\Controllers\CustomerController');

Route::get('/api/search/customers', [CustomerController::class, 'search']);
Route::post('/api/customers/create', [CustomerController::class, 'create']);
Route::get('/api/customers', [CustomerController::class, 'index']);


Route::resource('/api/products', 'App\Http\Controllers\ProductController');

Route::get('/api/search/products', [ProductController::class,'search']);
Route::post('/api/products/create', [ProductController::class, 'create']);
Route::get('/api/products', [ProductController::class, 'index']);
// Route::get('/api/products/show', [ProductController::class, 'show']);

Route::resource('/api/invoices', 'App\Http\Controllers\InvoiceController');

Route::get('{vue?}',function(){
    return view('welcome');
})->where('vue', '[\/\w\.-]*');


