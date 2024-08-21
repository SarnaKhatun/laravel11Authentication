<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;

Route::get('/', function () {
    return view('welcome');
});


Route::group(['middleware' => ['guest']], function (){
    Route::match(['get', 'post'],'register', [AuthController::class, 'register'])->name('register');
    Route::match(['get', 'post'],'login', [AuthController::class, 'login'])->name('login');
});

Route::get('forget-password', [AuthController::class, 'forgetPassword'])->name('forget.password');
Route::post('forget-password', [AuthController::class, 'forgetPasswordPost'])->name('forget.password.post');

Route::group(['middleware' =>['auth']], function (){
    Route::get('dashboard', [AuthController::class, 'dashboard'])->name('dashboard');
    Route::match(['get','post'],'profile', [AuthController::class, 'profile'])->name('profile');
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
