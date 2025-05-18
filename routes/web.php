<?php

use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\FileUploadController;
use App\Http\Controllers\OrderController;
use Illuminate\Support\Facades\Route;


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


Route::get('/register', [RegisterController::class, 'registerForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.store');

Route::get('/', [LoginController::class, 'loginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login'])->name('login.post');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    //only admin access
    Route::middleware('admin')->group(function () {
        Route::get('/admin', [DashboardController::class,'admin'])->name('admin');
    });
    //oder -> optimize query
    Route::controller(OrderController::class)->group(function(){
        Route::get('/orders', 'index')->name('order.index');
        Route::get('/orders-optimize', 'optimizeQuery')->name('order.optimize');
    });
    //file upload
    Route::controller(FileUploadController::class)->group(function(){
        Route::get('/index', 'index')->name('file.index');
        Route::get('/create', 'create')->name('file.create');
        Route::post('/store', 'store')->name('file.store');
    });
});
