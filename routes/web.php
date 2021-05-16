<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SellerController;
use App\Http\Controllers\TicketsController;
use App\Http\Controllers\DashboardController;
use App\Models\User;
use App\Models\tickets;
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
    $data = DashboardController::get_users_data(); //Chama função para pegar informações para o dashboard do Administrador
    return view('dashboard', compact('data'));
})->middleware(['auth'])->name('dashboard');

Route::post('open_ticket', [TicketsController::class, 'open_ticket'])->name('open_ticket');//Route que não precisa de login

Route::group(['middleware' => ['auth']], function () {
    //Rotas para Funcionarios
    Route::post('save_seller', [SellerController::class, 'post_data'])->name('save_seller');
    Route::post('update_seller', [SellerController::class, 'update_data'])->name('update_seller');
    Route::get('get_records', [SellerController::class, 'get_records'])->name('get_records');
    Route::get('get_seller/{id?}', [SellerController::class, 'get_seller'])->name('get_seller');
    Route::get('change_status/{id?}/{status?}', [SellerController::class, 'change_status'])->name('change_status');


    //Rotas para as Ocorrencias
    Route::get('get_all_tickets', [TicketsController::class, 'get_all_tickets'])->name('get_all_tickets');
    Route::get('get_ticket/{id?}', [TicketsController::class, 'get_ticket'])->name('get_ticket');
    Route::get('close_ticket/{id?}', [TicketsController::class, 'close_ticket'])->name('close_ticket');
});

require __DIR__.'/auth.php';
