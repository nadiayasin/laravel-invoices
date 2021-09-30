<?php

use Illuminate\Support\Facades\Route;
use App\Http\controllers\Admin\AdminController;
use App\Http\controllers\Admin\InvoicesController;
use App\Http\controllers\Admin\SectionsController;
use App\Http\controllers\Admin\ProductsController;
use App\Http\controllers\Admin\InvoicesDetailsController;
use App\Http\controllers\Admin\InvoicesAttachmentsController;
use App\Http\controllers\UserController;
use App\Http\controllers\RoleController;

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

Route::get('/', function () {
    return view('auth.login');
});

Route::get('/home', function () {
    return view('dashboard');
})->middleware(['auth'])->name('home');

require __DIR__.'/auth.php';

Route ::resource('/invoice',InvoicesController::class);
Route::get("/invoice/{id}/delete",[InvoicesController::class,'destroy'])->name("invoice.destroy");
Route ::get('/section/{id}',[InvoicesController::class,'getproducts']);
Route ::get('/status-show/{id}',[InvoicesController::class,'show'])->name("status_show");
Route ::POST('/status-update/{id}',[InvoicesController::class,'status_update'])->name("status_update");
Route::get('/export_invoice', [InvoicesController::class,'export']);

Route ::resource('/section',SectionsController::class);
Route::get("section/{id}/delete",[SectionsController::class,'destroy'])->name("section.delete");

Route ::resource('/product',ProductsController::class);
Route::post("product/{id}/delete",[ProductsController::class,'destroy'])->name("product.delete");

Route::get("invoice-details/{id}",[InvoicesDetailsController::class,'edit']);
//Route::get('/edit_invoice/{id}', [InvoicesController::class,'edit']);

Route::get("open-file/{invoice_number}/{file_name}",[InvoicesDetailsController::class,'open_file']);
Route::get("download/{invoice_number}/{file_name}",[InvoicesDetailsController::class,'get_file']);
Route::get('delete_file', [InvoicesDetailsController::class,'destroy'])->name('delete_file');;


Route::resource("attachment",InvoicesAttachmentsController::class);
Route::get('delete_file', [InvoicesAttachmentsController::class,'destroy'])->name('delete_file');;
// صلاحيات المستخدمين 
Route::group(['middleware' => ['auth']], function() {

    Route::resource('/roles',RoleController::class);
    
    Route::resource('/users',UserController::class);
    
    });
   

Route::get('/{page}', [ App\Http\controllers\Admin\AdminController::class,'index']);