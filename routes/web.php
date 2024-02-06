<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductsR;
use App\Http\Controllers\UsersR;
use App\Http\Controllers\LoginC;
use App\Http\Controllers\DashboardC;
use App\Http\Controllers\ProfileC;
use App\Http\Controllers\DataPembelianC;
use App\Http\Controllers\TransactionsR;
use App\Http\Controllers\LogC;
use App\Http\Controllers\LaporanC;

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

Route::get('/', function() {
    $subtitle = "Dashboard Pages";
    return view('dashboard', compact('subtitle'));
});

Route::get('dashboard', [DashboardC::class, 'index'])->name('dashboard.index');

Route::get('user/changepassword/{id}', [UsersR::class, 'changepassword'])->name('users.changepassword');
Route::put('users/change/{id}', [UsersR::class, 'change'])->name('users.change');
Route::resource('users',UsersR::class);

Route::get('login', [LoginC::class, 'login'])->name('login');
Route::post('login', [LoginC::class, 'login_action'])->name('login.action');
Route::get('logout', [LoginC::class, 'logout'])->name('logout');

Route::get('profile',[ProfileC::class,'index'])->name('profile.index');
Route::get('profile/edit/{id}',[ProfileC::class,'edit'])->name('profile.edit');
Route::put('profile/update/{id}',[ProfileC::class,'update'])->name('profile.update');
Route::get('profile/changepassword/{id}',[ProfileC::class,'changepassword'])->name('profile.changepassword');
Route::put('profile/change/{id}',[ProfileC::class,'change'])->name('profile.change');

Route::get('datapembelian',[DataPembelianC::class,'index'])->name('datapembelian.index');

Route::resource('products',ProductsR::class);

Route::get('transactions', [TransactionsR::class, 'index'])->name('transactions.index');
Route::get('transactions/create', [TransactionsR::class, 'create'])->name('transactions.create');
Route::post('transactions/store', [TransactionsR::class, 'store'])->name('transactions.store');
Route::get('transactions/edit/{id}', [TransactionsR::class, 'edit'])->name('transactions.edit');
Route::put('transactions/update/{id}', [TransactionsR::class, 'update'])->name('transactions.update');
Route::delete('/transactions/{id}', [TransactionsR::class, 'destroy'])->name('transactions.destroy');

Route::get('log',[LogC::class,'index'])->name('log.index');

Route::get('transactions/pdf/{id}', [TransactionsR::class, 'pdf'])->name('transactions.pdf');
Route::get('produk/pdf', [ProductsR::class, 'pdf'])->name('products.pdf');

Route::get('laporan', [LaporanC::class, 'index'])->name('laporan.index');
Route::get('/laporan/filter', [LaporanC::class, 'filter'])->name('laporan.filter');
Route::get('/laporan/export', [LaporanC::class, 'export'])->name('laporan.export');


