<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

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
    return view('welcome');
});

//Route::resource('products', ProductController::class);
Route::get('products/index',\App\Http\Livewire\ProductIndex::class)->name('products.index');
Route::get('products/create',\App\Http\Livewire\ProductForm::class)->name('products.create');
Route::get('products/{product}/edit',\App\Http\Livewire\ProductForm::class)->name('products.edit');









Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
