<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
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

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::post('save_seller', [SellerController::class, 'post_data'])->name('save_seller');
Route::get('get_records', [SellerController::class, 'get_records'])->name('get_records');
Route::get('get_seller/{id?}', [SellerController::class, 'get_seller'])->name('get_seller');
Route::get('change_status/{id?}/{status?}', [SellerController::class, 'change_status'])->name('change_status');
require __DIR__.'/auth.php';
