<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Pos\CategoryController;
use App\Http\Controllers\Pos\CustomerController;
use App\Http\Controllers\Pos\ProductController;
use App\Http\Controllers\Pos\SupplierController;
use App\Http\Controllers\Pos\UnitController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

 //Admin All Route
Route::controller(AdminController::class)->group(function(){
Route::get('/admin/logout', 'destroy')->name('admin.logout');
Route::get('/admin/profile', 'Profile')->name('admin.profile');
Route::get('/edit/profile', 'EditProfile')->name('edit.profile');
Route::post('/store/profile', 'StoreProfile')->name('store.profile');
Route::get('/change/password', 'ChangePassword')->name('change.password');
Route::post('/update/password', 'UpdatePassword')->name('update.password');
});

 //Supplier All Route
Route::controller(SupplierController::class)->group(function(){
Route::get('/supplier/all', 'SupplierAll')->name('supplier.all');
Route::get('/supplier/add', 'SupplierAdd')->name('supplier.add');
Route::post('/supplier/store', 'SupplierStore')->name('supplier.store');
Route::get('/supplier/edit/{id}', 'SupplierEdit')->name('supplier.edit');
Route::post('/supplier/update', 'SupplierUpdate')->name('supplier.update');
Route::get('/supplier/delete/{id}', 'SupplierDelete')->name('supplier.delete');

});

 //Customer All Route
Route::controller(CustomerController::class)->group(function(){
Route::get('/customer/all', 'CustomerAll')->name('customer.all');
Route::get('/customer/add', 'CustomerAdd')->name('customer.add');
Route::post('/customer/store', 'CustomerStore')->name('customer.store');
Route::get('/customer/edit/{id}', 'CustomerEdit')->name('customer.edit');
Route::post('/customer/update', 'CustomerUpdate')->name('customer.update');
Route::get('/customer/delete/{id}', 'CustomerDelete')->name('customer.delete');

});
 //Units All Route
Route::controller(UnitController::class)->group(function(){
Route::get('/unit/all', 'UnitAll')->name('unit.all');
Route::get('/unit/add', 'UnitAdd')->name('unit.add');
Route::post('/unit/store', 'UnitStore')->name('unit.store');
Route::get('/unit/edit/{id}', 'UnitEdit')->name('unit.edit');
Route::post('/unit/update', 'UnitUpdate')->name('unit.update');
Route::get('/unit/delete/{id}', 'UnitDelete')->name('unit.delete');

});

 //Category All Route
Route::controller(CategoryController::class)->group(function(){
Route::get('/category/all', 'CategoryAll')->name('category.all');
Route::get('/category/add', 'CategoryAdd')->name('category.add');
Route::post('/category/store', 'CategoryStore')->name('category.store');
Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
Route::post('/category/update', 'CategoryUpdate')->name('category.update');
Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');

});

 //Product All Route
Route::controller(ProductController::class)->group(function(){
Route::get('/product/all', 'ProductAll')->name('product.all');
Route::get('/category/add', 'CategoryAdd')->name('category.add');
Route::post('/category/store', 'CategoryStore')->name('category.store');
Route::get('/category/edit/{id}', 'CategoryEdit')->name('category.edit');
Route::post('/category/update', 'CategoryUpdate')->name('category.update');
Route::get('/category/delete/{id}', 'CategoryDelete')->name('category.delete');

});

Route::get('/dashboard', function () {
    return view('admin.index');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
