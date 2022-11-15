<?php

use App\Http\Controllers\CustomerController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\Invoice_newController;
use App\Http\Controllers\Product_newController;
use App\Http\Controllers\VendorController;
use App\Http\Controllers\PgController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;


// Route::get('/', function () {
//     return view('welcome');
// });
// Route::resource('/api/customers', 'App\Http\Controllers\CustomerController');
// Route::resource('/api/page', 'App\Http\Controllers\PgController');
Auth::routes();
Route::middleware(['auth'])->group(function(){



Route::get('/api/page', [PgController::class,'index']);
Route::get('/api/page/create', [PgController::class,'create']);
Route::post('/api/page/create', [PgController::class,'create']);
Route::post('/api/page/store', [PgController::class,'store']);
Route::get('/api/page/{$id}', [PgController::class,'editData']);
Route::get('/api/pages', [PgController::class,'update']);



// Route::get('/api/page/ahmed', [PgController::class,'ahmed']);
Route::get('/api/ahmed','PgController@ahmed');


// Route::get('/page/show', [PgController::class,'show']);
// Route::put('/page/update', [PgController::class,'update']);

// Route::resource('/api/customers', 'App\Http\Controllers\CustomerController');

Route::get('/api/search/customers', [CustomerController::class, 'search']);
Route::get('api/search/customers/{firstname}',[CustomerController::class, 'search']);
Route::post('/api/customers/create', [CustomerController::class, 'create']);
Route::get('/api/customers', [CustomerController::class, 'index']);


Route::resource('/api/product_new','App\Http\Controllers\Product_newController');

Route::get('/api/search/product_new', [Product_newController::class,'search']);
Route::post('/api/product_new/create', [Product_newController::class, 'create']);
Route::get('/api/product_new/create', [Product_newController::class, 'create']);


Route::resource('/api/products', 'App\Http\Controllers\ProductController');

Route::get('/api/search/products', [ProductController::class,'search']);
Route::post('/api/products/create', [ProductController::class, 'create']);
// Route::get('/api/products', [ProductController::class, 'index']);
// Route::get('/api/products/show', [ProductController::class, 'show']);


Route::resource('/api/vendors', 'App\Http\Controllers\VendorController');

Route::get('/api/search/vendors', [VendorController::class, 'search']);
Route::post('/api/vendors/create', [VendorController::class, 'create']);
// Route::get('/api/vendors', [VendorController::class, 'index']);
Route::get('/api/vendors/index', [VendorController::class, 'index']);


Route::resource('/api/invoices', 'App\Http\Controllers\InvoiceController');
Route::get('/search/', [InvoiceController::class,'search'])->name('search');
// Route::get('api/invoices/search/{customer}',[InvoiceController::class, 'search']);
// Route::get('/api/search/invoices', [InvoiceController::class,'search']);

Route::resource('/api/invoice_new', 'App\Http\Controllers\Invoice_newController');
Route::get('/search/', [Invoice_newController::class,'search'])->name('search');

Route::get('{vue?}',function(){
    return view('welcome');
})->where('vue', '[\/\w\.-]*');


});


Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
